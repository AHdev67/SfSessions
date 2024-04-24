<?php

namespace App\Controller;

use App\Entity\Stagiaire;
use App\Form\StagiaireType;
use App\Repository\StagiaireRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class StagiaireController extends AbstractController
{
    //-------------------------------------------------
    //METHODE INDEX QUI RENVOIE LA LISTE DES STAGIAIRES
    //-------------------------------------------------
    #[Route('/stagiaire', name: 'app_stagiaire')]
    public function index(StagiaireRepository $stagiaireRepository): Response
    {
        $stagiaires = $stagiaireRepository->findBy([], ["nom" => "ASC"]);
        return $this->render('stagiaire/index.html.twig', [
            'controller_name' => 'StagiaireController',
            'stagiaires' => $stagiaires
        ]);
    }

    //-----------------------------------------------------------------------------------
    //METHODE NEW_EDIT FORM QUI RENVOIE UN FORMULAIRE D'AJOUT / MODIFICATION DE STAGIAIRE
    //-----------------------------------------------------------------------------------
    #[Route('/stagiaire/new', name: 'new_stagiaire')]
    #[Route('/stagiaire/{id}/edit', name: 'edit_stagiaire')]
    public function new_edit(Stagiaire $stagiaire = null, Request $request, EntityManagerInterface $entityManager): Response
    {
        if(!$stagiaire){
            $stagiaire = new Stagiaire();
            $sessions = null;
        }
        else{
            $sessionRepo = $entityManager->getRepository(Session::class);
            $stagiaires = $sessionRepo->findAll();
        }

        $form = $this->createForm(StagiaireType::class, $stagiaire);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            
            $stagiaire = $form->getData();
            //equivalent PDO prepare
            $entityManager->persist($stagiaire);
            //equivalent PDO execute
            $entityManager->flush();

            return $this->redirectToRoute('add_stagiaire');
        }

        return $this->render('stagiaire/new.html.twig', [
            'formAddStagiaire' => $form,
            'edit' => $stagiaire->getId(),
            'sessions'=>$sessions,
            'stagiaire'=>$stagiaire
        ]);
    }
}
