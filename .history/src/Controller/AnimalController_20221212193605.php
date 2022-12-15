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
     * @Route("/animaux/{idEnclo}", name="app_animals")
     */
    public function index($idEnclo, ManagerRegistry $doctrine): Response
    {
        $enclo = $doctrine->getRepository(Enclos::class)->find($idEnclo);

        if(!$enclo) {
            throw $this->createNotFoundException("Aucun enclo avec l'id $idEnclo");
        }
        
        return $this->render('animal/index.html.twig', [
            'enclo' => $enclo,
            'animaux' => $enclo->getAnimals(),
        ]);
    }

    /**
     * @Route("/animal/ajouter", name="app_animal_ajouter")
     */
    public function ajouterAnimal(ManagerRegistry $doctrine, Request $request): Response
    {
        $animal = new Animal();

        $form = $this->createForm(AnimalType::class, $animal);

        $form->handleRequest($request);

        $dateArrive = $animal->getDateArrivee();
        dd($dateArrive)

        if($form->isSubmitted() && $form->isValid()) {

            // Verifie si la date de naissance est supérieure à la date d'arrivée
            

            $em = $doctrine->getManager();
            $em->persist($animal);
            $em->flush();

            return $this->redirectToRoute("app_animal", ["idEnclo" => $animal->getEnclos()->getId()]);
        }

        return $this->render("animal/ajouter.html.twig", [
            'formulaire' => $form->createView()
        ]);
    }

    /**
     * @Route("/animal/modifier/{id}", name="app_animal_modifier")
     */
    public function modifierAnimal($id, ManagerRegistry $doctrine, Request $request) : Response
    {
        $animal = $doctrine->getRepository(Animal::class)->find($id);

        if(!$animal){
            throw $this->createNotFoundException("Pas d'animal avec l'id $id");
        }

        $form = $this->createForm(AnimalType::class, $animal);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em = $doctrine->getManager();
            $em->persist($animal);
            $em->flush();

            return $this->redirectToRoute("app_animals", ["idEnclo" => $animal->getEspace()->getId()]);
        }

        return $this->render("animal/modifier.html.twig", [
            "animal" => $animal,
            'formulaire' => $form->createView()
        ]);
    }

    /**
     * @Route("/animal/supprimer/{id}", name="app_animal_supprimer")
     */
    public function supprimerAnimal($id, ManagerRegistry $doctrine, Request $request) : Response
    {
        $animal = $doctrine->getRepository(Animal::class)->find($id);

        if(!$animal){
            throw $this->createNotFoundException("Pas d'animal avec l'id $id");
        }

        $form = $this->createForm(AnimalSupprimerType::class, $animal);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em=$doctrine->getManager();

            $em->remove($animal);

            $em->flush();

            return $this->redirectToRoute("app_animals", ["idEnclo" => $animal->getEspace()->getId()]);
        }

        return $this->render("animal/supprimer.html.twig", [
            "animal" => $animal,
            'formulaire' => $form->createView()
        ]);
    }
}
