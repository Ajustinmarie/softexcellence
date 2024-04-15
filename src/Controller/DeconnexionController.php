<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class DeconnexionController extends AbstractController
{
    /**
     * @Route("/deconnexion", name="deconnexion")
     */
    public function index(SessionInterface $session): Response
    {
        
         // Effacer toute la session
         $session->clear();


        return $this->render('espace_login_nouveau/deconnexion.html.twig', [
            'controller_name' => 'DeconnexionController',
        ]);
    }
}
