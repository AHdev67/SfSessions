<?php

namespace App\Controller;

use DateTime;
use App\Entity\Formateur;
use App\Form\FormateurType;
use App\Repository\FormateurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FormateurController extends AbstractController
{
    //-------------------------------------------------
    //METHODE INDEX QUI RENVOIE LA LISTE DES FORMATEURS
    //-------------------------------------------------
    #[Route('/formateur', name: 'app_formateur')]
    public function index(FormateurRepository $formateurRepository): Response
    {
        $formateurs = $formateurRepository->findBy([], ["nom" => "ASC"]);
        return $this->render('formateur/index.html.twig', [
            'controller_name' => 'FormateurController',
            'formateurs' => $formateurs
        ]);
    }

    //-----------------------------------------------------------------------------------
    //METHODE NEW_EDIT FORM QUI RENVOIE UN FORMULAIRE D'AJOUT / MODIFICATION DE FORMATEUR
    //-----------------------------------------------------------------------------------
    #[Route('/formateur/new', name: 'new_formateur')]
    #[Route('/formateur/{id}/edit', name: 'edit_formateur')]
    public function new_edit(Formateur $formateur = null, Request $request, EntityManagerInterface $entityManager): Response
    {
        if(!$formateur){
            $formateur = new Formateur();
            $sessions = null;
        }

        $form = $this->createForm(FormateurType::class, $formateur);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            
            $formateur = $form->getData();
            //equivalent PDO prepare
            $entityManager->persist($formateur);
            //equivalent PDO execute
            $entityManager->flush();

            return $this->redirectToRoute('app_formateur');
        }

        return $this->render('formateur/new.html.twig', [
            'formAddFormateur' => $form,
            'edit' => $formateur->getId(),
            'formateur'=>$formateur
        ]);
    }

    //----------------------------------------
    //METHODE DELETE QUI SUPPRIME UN FORMATEUR
    //----------------------------------------
    #[Route('/formateur/{id}/delete', name: 'delete_formateur')]
    public function delete(Formateur $formateur, EntityManagerInterface $entityManager)
    {
        $entityManager->remove($formateur);
        $entityManager->flush();

        return $this->redirectToRoute('app_formateur');
    }

}
