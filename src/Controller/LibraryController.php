<?php

namespace App\Controller;

use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;


#[Route('/library', name: 'library')]

final class LibraryController extends AbstractController
{

    #[Route('/list', name: 'library_list')]
    public function list(Request $request, LoggerInterface $logger): JsonResponse
    {
        $title = $request->get('title', 'titulo de respaldo');
        $logger->info('List action called 2 ');
        $response = new JsonResponse();

        $response->setData([
            'succes' => true,
            'data' => [
                [
                    'id' => 1,
                    'title' => "El esclavo",
                ],
                [
                    'id' => 2,
                    'title' => "Game of Thrones",
                ],
                [
                    'id' => 3,
                    'title' => $title,
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