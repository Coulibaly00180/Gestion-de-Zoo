<?php

namespace App\Controller;

use App\Entity\Animal;
use App\Form\AnimalType;
use App\Entity\Enclos;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AnimalController extends AbstractController
{
    /**
     * @Route("/animal/{idEnclo}", name="app_animal")
     */
    public function index($idEnclo, ManagerRegistry $doctrine): Response
    {
        $enclos = $doctrine->getRepository(Enclos::class)->find($idEnclo);

        if(!$enclos) {
            throw $this->createNotFoundException("Aucunn espace avec l'id $idEnclo");
        }
        
        return $this->render('enclos/index.html.twig', [
            'enclos' => $enclos,
            'animal' => $enclos->getAnimal(),
        ]);
    }

    /**
     * @Route("/animal/ajouter", name="app_animal_ajouter")
     */
    public function ajouterAnimal(ManagerRegistry $doctrine, Request $request): Response
    {
        $animal = new Animal();

        $form = $this->createForm(EnclosType::class, $animal);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $em = $doctrine->getManager();
            $em->persist($animal);
            $em->flush();

            return $this->redirectToRoute("app_animal", ["idEnclo" => $animal->getEnclos()->getId()]);
        }

        return $this->render("animal/ajouter.html.twig", [
            'formulaire' => $form->createView()
        ]);
    }
}
