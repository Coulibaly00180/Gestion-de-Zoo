<?php

namespace App\Controller;

use App\Entity\Enclos;
use Symfony\Bridge\Doctrine\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AnimalController extends AbstractController
{
    /**
     * @Route("/animal/{$idEnclo}", name="app_animal")
     */
    public function index($idEnclo, ManagerRegistry $doctrine, Request $request): Response
    {
        $enclo = $doctrine->getRepository(Enclos::class)->find($idEnclo);

        if(!$enclo) {
            throw $this->createNotFoundException("Aucunn espace avec l'id $idEnclo");
        }
        
        return $this->render('enclos/index.html.twig', [
            'enclo' => $enclo,
            'animal' => $enclo->getAnimal(),
        ]);
    }
}
