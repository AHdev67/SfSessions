<?php

namespace App\Controller;

use App\Entity\Session;
use App\Entity\Stagiaire;
use App\Form\SessionType;
use App\Repository\SessionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SessionController extends AbstractController
{
    //----------------------------------------------
    //METHODE INDEX QUI RENVOIE LA LISTE DES SESSIONS
    //----------------------------------------------
    #[Route('/session', name: 'app_session')]
    public function index(SessionRepository $sessionRepository): Response
    {
        $sessions = $sessionRepository->findBy([], ["dateDebut" => "DESC"]);
        return $this->render('session/index.html.twig', [
            'controller_name' => 'SessionController',
            'sessions' => $sessions
        ]);
    }

    //---------------------------------------------------------------------------------
    //METHODE NEW_EDIT FORM QUI RENVOIE UN FORMULAIRE D'AJOUT / MODIFICATION DE SESSION
    //---------------------------------------------------------------------------------
    #[Route('/session/new', name: 'new_session')]
    #[Route('/session/{id}/edit', name: 'edit_session')]
    public function new_edit(Session $session = null, Request $request, EntityManagerInterface $entityManager): Response
    {
        if(!$session){
            $session = new Session();
            $stagiaires = null;
        }
        else{
            $stagiaireRepo = $entityManager->getRepository(Stagiaire::class);
            $stagiaires = $stagiaireRepo->findAll();
        }

        $form = $this->createForm(SessionType::class, $session);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            
            $session = $form->getData();
            //equivalent PDO prepare
            $entityManager->persist($session);
            //equivalent PDO execute
            $entityManager->flush();

            return $this->redirectToRoute('app_session');
        }

        return $this->render('session/new.html.twig', [
            'formAddSession' => $form,
            'edit' => $session->getId(),
            'stagiaires'=>$stagiaires,
            'session'=>$session
        ]);
    }

    //--------------------------------------------------
    //METHODE ADD QUI INSCRIT UN STAGIAIRE A UNE SESSION
    //--------------------------------------------------
    #[Route('/session/{id}/edit/{stagiaireId}/add', name: 'add_stagiaire')]
    public function add(Session $session, #[MapEntity(id: 'stagiaireId')] Stagiaire $stagiaire, EntityManagerInterface $entityManager)
    {
        $session->addStagiaire($stagiaire);

        $entityManager->persist($session);
        $entityManager->flush();

        return $this->redirectToRoute('edit_session', ['id'=>$session->getId()]);
    }

    //------------------------------------------------------------
    //METHODE REMOVE QUI DESINSCRIT UN STAGIAIRE D'UNE UNE SESSION
    //------------------------------------------------------------
    #[Route('/session/{id}/edit/{stagiaireId}/remove', name: 'remove_stagiaire')]
    public function remove(Session $session, Stagiaire $stagiaire, EntityManagerInterface $entityManager)
    {
        $session->removeStagiaire($stagiaire);

        $entityManager->persist($session);
        $entityManager->flush();

        return $this->redirectToRoute('edit_session', ['id'=>$session->getId()]);
    }

    //---------------------------------------
    //METHODE DELETE QUI SUPPRIME UNE SESSION
    //---------------------------------------
    #[Route('/session/{id}/delete', name: 'delete_session')]
    public function delete(Session $session, EntityManagerInterface $entityManager)
    {
        $entityManager->remove($session);
        $entityManager->flush();

        return $this->redirectToRoute('app_session');
    }

    //--------------------------------------------------
    //METHODE SHOW QUI RENVOIE LES DETAILS D'UNE SESSION
    //--------------------------------------------------
    // #[Route('/session/{id}', name: 'show_session')]
    // public function show(Session $session): Response
    // {
    //     return $this->render('session/show.html.twig', [
    //         'session' => $session
    //     ]);
    // }
}
