<?php

namespace App\Controller;

use App\Entity\Espace;
use App\Form\EspaceType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use function PHPUnit\Framework\isNull;

class EspaceController extends AbstractController
{
    /**
     * @Route("/", name="app_espace")
     */
    public function index(ManagerRegistry $doctrine): Response
    {
        // recherche des enclos dans la base de données 
        // pour cela on a besoins d'un repository
        $repository = $doctrine->getRepository(Espace::class);
        $espaces = $repository->findAll(); // selection de tout les elements de espace

        return $this->render('espace/index.html.twig', [
            'espaces' => $espaces,
        ]);
    }


    /**
     * @Route("/espace/ajouter", name="app_espace_ajouter")
     */
    public function ajouter(ManagerRegistry $doctrine, Request $request ): Response
    {
        // on crée un espace vide ( equivaut à dire on creé une class espace qui est vide)
        $espace = new Espace();

        
        // on crée le formulaire espace
        $form = $this->createForm(EspaceType::class, $espace);

        $form->handleRequest($request);

        $dataOuvre = $form->getData()->getDateOuverture();

        if ($form->isSubmitted() && $form->isValid()){

            // la class espace est maintenant rempli car elle recupère les données du formulaire
            $em = $doctrine->getManager();

            //on lui dit qu'on veut mettre la classe espace (rempli) dans la table
            $em->persist($espace);

            //on génère l'appel SQL (l'insert ici)
            $em->flush();

            //on revient à l'accueil
            return $this->redirectToRoute("app_espace");
        }
        return $this->render("espace/ajouter.html.twig",[
            "formulaire"=>$form->createView()
         ]);

    }

    /**
     * @Route("espace/modifier/{id}" , name="app_espace_modifier")
     */
    public function modifier($id, ManagerRegistry $doctrine, Request $request ):Response {
        //créer le formulaire sur le même principe que dans ajouter
        //mais avec un espace existante
        $espace = $doctrine->getRepository(Espace::class)->find($id);

        //je vais gérer le fait que l'id n'existe pas
        if (!$espace){
            throw $this->createNotFoundException("Pas de catégorie avec l'id $id");
        }

        //Si j'arrive là c'est qu'elle existe en BDD
        //à partir de ça je crée le formulaire
        $form=$this->createForm(EspaceType::class, $espace);

        //On gère le retour du formulaire tout de suite
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            //l'objet espace est rempli
            //on va utiliser l'entity manager de doctrine
            $em=$doctrine->getManager();
            //on lui dit qu'on veut mettre la espace dans la table
            $em->persist($espace);

            //on génère l'appel SQL (update ici)
            $em->flush();

            //on revient à l'accueil
            return $this->redirectToRoute("app_espace");
        }

        return $this->render("espace/modifier.html.twig",[
            "espace"=>$espace,
            "formulaire"=>$form->createView()
        ]);

    }

}
