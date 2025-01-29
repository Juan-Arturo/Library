<?php

namespace App\Controller;

use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Book;
use App\Repository\BookRepository;
use Doctrine\ORM\EntityManagerInterface;

#[Route('/library', name: 'library')]

final class LibraryController extends AbstractController
{

    #[Route('/books/list', name: 'library_list')]
    public function list(Request $request, BookRepository $BookRepository
    ): JsonResponse
    {
       // $title = $request->get('title', 'titulo de respaldo');
       // $logger->info('List action called 2 ');
       
       
       //Hacemos un array de books usando el findAll de booksRepository
        $books = $BookRepository->findAll();
        $booksArray = [];
        foreach ($books as $book) {
            $booksArray[] = [
                'id' => $book->getId(),
                'title' => $book->getTitle(),
                'image' => $book->getImage(),
            ];
        }

        //Preparamos la respuesta JSON con el array de books
        $response = new JsonResponse();
        $response->setData([
            'succes' => true,
            'data' => $booksArray,
                
        ]);

        return $response;
    }

    #[Route('/books/create', name: 'create_book')]
    public function createBook(Request $request, EntityManagerInterface $em): JsonResponse
    {
        //lo asocio a la entidad book
        $book = new Book();

        //Preparamos la respuesta JSON
        $response = new JsonResponse();


        //buscamos el title de la entidad book
        $title = $request->get('title',null);


        //comparativo de null
        if($title == null){
            $response->setData([
                'succes' => false,
                'error' => [
                    'message' => 'El campo title no puede ser null',
                    'code' => 400
                ]
            ]);
            return $response;
        }

        //uso el setter de la entidad book
        $book->setTitle($title);

        //Comunico a EntityManagerInterface de la existencia de la entidad book
        $em->persist($book);

        //Guardo los cambios en la base de datos en este caso los cambios son la existencia de la entidad book
        $em->flush();

        $response->setData([
            'succes' => true,
            'data' => [
                [
                    'id' => $book->getId(),
                    'title' => $book->getTitle(),
                ]
            ]
        ]);

        return $response; 
    }

}

































/*ejemplo de funcion enrutada
#[Route('/list', name: 'library_list')]
public function list(): JsonResponse
{
    return $this->json([
        'message' => 'Welcome to your new controller!',
        'path' => 'src/Controller/LibraryController.php',
    ]);
}
*/