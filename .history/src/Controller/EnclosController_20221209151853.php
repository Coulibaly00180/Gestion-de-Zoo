<?php

namespace App\Controller;

use App\Entity\Enclos;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EnclosController extends AbstractController
{
    /**
     * @Route("/enclos/{idCategorie}", name="app_enclos")
     */
    public function index(ManagerRegistry $doctrine): Response
    {
        // recherche des enclos dans la base de données 
        // pour cela on a besoins d'un repository
        $repository = $doctrine->getRepository(Enclos::class);
        
        return $this->render('enclos/index.html.twig', [
            'controller_name' => 'EnclosController',
        ]);
    }
}
