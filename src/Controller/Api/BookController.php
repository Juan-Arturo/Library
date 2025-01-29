<?php

namespace App\Controller\Api;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;
use App\Repository\BookRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Book;

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
    public function postBook( EntityManagerInterface $em){


      // Crear un nuevo libro
      $book = new Book();
      $book->setTitle('Test Title 2');  

      // Persistir el libro
      $em->persist($book);
      $em->flush();

      // Responder con el libro creado (puedes devolverlo en formato JSON)
      return $this->json($book, 201, [], ['groups' => 'book']);
  }
    
}
