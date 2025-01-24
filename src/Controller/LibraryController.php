<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;


#[Route('/library', name: 'library')]

final class LibraryController extends AbstractController
{
    #[Route('/list', name: 'library_list')]
    public function list(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/LibraryController.php',
        ]);
    }

    
}
