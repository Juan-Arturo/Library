<?php

namespace App\Controller\Api;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;
use App\Repository\BookRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Book;
use Symfony\Component\HttpFoundation\Request;
use App\Form\Type\BookFormType;

class BookController extends AbstractController{

    #[Route('/books', name: 'get_books')]
    public function getBooks(BookRepository $bookRepository, SerializerInterface $serializer)
    {
        // Obtener los datos de los libros
        $books = $bookRepository->findAll();

        // Serializar los datos con los grupos definidos
        $jsonBooks = $serializer->serialize($books, 'json', ['groups' => 'book']);

        // Retornar la respuesta JSON
        return new JsonResponse($jsonBooks, 200, [], true);
    }


    #[Route('/books/create', name: 'post_book', methods: ['POST'])]
    public function postBook(EntityManagerInterface $em, Request $request, SerializerInterface $serializer)
    {
        // Decodificar el JSON
        $data = json_decode($request->getContent(), true);
    
        // Verificar que los datos sean válidos y que contengan un 'title'
        if (!$data || !isset($data['title'])) {
            return new JsonResponse(['message' => 'Invalid JSON data or missing title'], 400);
        }
    
        // Crear un nuevo libro
        $book = new Book();
        $form = $this->createForm(BookFormType::class, $book);
    
        // Asignar los datos del formulario (sin la envoltura 'book_form')
        $form->submit($data);
    
        // Validar el formulario
        if ($form->isSubmitted() && $form->isValid()) {
            // Persistir el libro
            $em->persist($book);
            $em->flush();
    
            // Serializar el libro
            $bookData = $serializer->serialize($book, 'json', ['groups' => 'book']);
    
            return new JsonResponse([
                'message' => 'Book created successfully',
                'book' => json_decode($bookData)
            ], 201);
        }
    
        // Si el formulario no es válido, devolver los errores
        return new JsonResponse([
            'message' => 'Invalid form data',
            'errors' => (string) $form->getErrors(true, false)
        ], 400);
    }
    
    
}
