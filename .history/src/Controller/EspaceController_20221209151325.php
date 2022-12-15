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
        $repository = $doctrine->getRepository(Espace::class);
        $espaces = $repository->findAll();

        return $this->render('espace/index.html.twig', [
            'espaces' => $espaces,
        ]);
    }


    /**
     * @Route("/espace/ajouter", name="app_espace_ajouter")
     */
    public function ajouter(ManagerRegistry $doctrine, Request $request ): Response
    {
        $espace = new Espace();

        $form = $this->createForm(EspaceType::class, $espace);

        $form->handleRequest($request);

        $dataOuvre = $form->getData()->getDateOuverture();

        if ($form->isSubmitted() && $form->isValid()){

            dd($espace);

            $em = $doctrine->getManager();

            $em->persist($espace);

            $em->flush();

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

    /**
     * @Route("/espace/supprimer/{id}", name="app_espace_supprimer")
     */
    public function supprimer($id, ManagerRegistry $doctrine, Request $request): Response{
        //créer le formulaire sur le même principe que dans ajouter
        //mais avec une catégorie existante
        $espace = $doctrine->getRepository(espace::class)->find($id);

        //je vais gérer le fait que l'id n'existe pas
        if (!$espace){
            throw $this->createNotFoundException("Pas d'espace avec l'id $id");
        }

        //Si j'arrive là c'est qu'elle existe en BDD
        //à partir de ça je crée le formulaire
        $form=$this->createForm(EspaceSupprimerType::class, $espace);

        //On gère le retour du formulaire tout de suite
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            //l'objet catégorie est rempli
            //on va utiliser l'entity manager de doctrine
            $em=$doctrine->getManager();
            //on lui dit qu'on supprimer la catégorie
            $em->remove($espace);

            //on génère l'appel SQL (update ici)
            $em->flush();

            //on revient à l'accueil
            return $this->redirectToRoute("app_espace");
        }

        return $this->render("espace/supprimer.html.twig",[
            "espace"=>$espace,
            "formulaire"=>$form->createView()
        ]);
    }

}
