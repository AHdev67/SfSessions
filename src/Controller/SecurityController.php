<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Repository\UtilisateurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route(path: '/', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    //---------------------------------------------------
    //METHODE USERS QUI RENVOIE LA LISTE DES UTILISATEURS
    //---------------------------------------------------
    #[Route('/security', name: 'app_users')]
    public function index(UtilisateurRepository $utilisateurRepository): Response
    {
        $utilisateurs = $utilisateurRepository->findBy([], ["email" => "DESC"]);
        return $this->render('security/utilisateurs.html.twig', [
            'controller_name' => 'SessionController',
            'utilisateurs' => $utilisateurs
        ]);
    }

    #[Route('/security/utilisateurs/{id}/grant', name: 'grant_admin')]
    public function grant(Utilisateur $utilisateur, EntityManagerInterface $entityManager): Response
    {
        if (in_array("ROLE_ADMIN", $utilisateur->getRoles()))
        {
            $utilisateur->removeRole("ROLE_ADMIN");
            $entityManager->persist($utilisateur);
            $entityManager->flush();
        }
        else
        {
            $utilisateur->addRole("ROLE_ADMIN");
            $entityManager->persist($utilisateur);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_users');
    }
}
