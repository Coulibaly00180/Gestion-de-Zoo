<?php

namespace App\Controller;

use App\Entity\Animal;
use App\Entity\Enclos;
use App\Form\EnclosType;

//
use App\Entity\Espace;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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

    /**
     * @Route("/enclo/ajouter/", name="app_enclo_ajouter")
     */
    public function ajouterEnclos(ManagerRegistry $doctrine, Request $request) : Response
    {
        $enclos = new Enclos();

        $form = $this->createForm(EnclosType::class, $enclos);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $em = $doctrine->getManager();
            $em->persist($enclos);
            $em->flush();

            return $this->redirectToRoute("app_enclos", ["idEspace" => $enclos->getEspace()->getId()]);
        }

        return $this->render("enclos/ajouter.html.twig", [
            'formulaire' => $form->createView()
        ]);
    }

    /**
     * @Route("/enclos/modifier/{id}", name="app_enclos_modifier")
     */
    public function modifierEnclos($id, ManagerRegistry $doctrine, Request $request) : Response
    {
        $enclos = $doctrine->getRepository(Enclos::class)->find($id);

        if(!$enclos){
            throw $this->createNotFoundException("Pas d'enclos avec l'id $id");
        }

        $form = $this->createForm(EnclosType::class, $enclos);

        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()){

            // Si l'enclos est mis en quarantaine, automatiquement les animaux sont mis en quarantaine
            foreach($enclos->getAnimals() as $animal) {
                $animal = $doctrine->getRepository(Animal::class)->find($animal->getId());
                dd($animal);
            }

            $em = $doctrine->getManager();
            $em->persist($enclos);
            $em->flush();

            return $this->redirectToRoute("app_enclos", ["idEspace" => $enclos->getEspace()->getId()]);
        }

        return $this->render("enclos/modifier.html.twig", [
            "enclo" => $enclos,
            'formulaire' => $form->createView()
        ]);
    }

    /**
     * @Route("/enclos/supprimer/{id}", name="app_enclos_supprimer")
     */
     public function supprimerEnclos($id, ManagerRegistry $doctrine, Request $request) : Response
    {
        $enclos = $doctrine->getRepository(Enclos::class)->find($id);

        if(!$enclos){
            throw $this->createNotFoundException("Pas d'enclos avec l'id $id");
        }

        $form = $this->createForm(EnclosSupprimerType::class, $enclos);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em=$doctrine->getManager();

            $em->remove($enclos);

            $em->flush();

            return $this->redirectToRoute("app_enclos", ["idEspace" => $enclos->getEspace()->getId()]);
        }

        return $this->render("enclos/supprimer.html.twig", [
            "enclo" => $enclos,
            'formulaire' => $form->createView()
        ]);
    }
}
