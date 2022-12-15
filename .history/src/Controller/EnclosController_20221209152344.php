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
     * @Route("/enclos/{idEspace}", name="app_enclos")
     */
    public function index($idEspace, ManagerRegistry $doctrine): Response
    {
        $espace = $doctrine->getRepository(Espace::class)->find($idEspace);

        if(!$espace) {
            throw $this->createNotFoundException("Aucunn espace avec l'id $idEspace");
        }
        
        return $this->render('enclos/index.html.twig', [
            'espace' => $espace,
            'enclos' => $espace->getEnclos(),

        ]);
    }
}
