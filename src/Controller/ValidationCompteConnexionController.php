<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class ValidationCompteConnexionController extends AbstractController
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager=$entityManager;
    }


    /**
     * @Route("/validation/compte/connexion/{token_user}", name="app_validation_compte_connexion")
     */
    public function index($token_user): Response
    {
        $notification=null;

        $activation=$this->entityManager->getRepository(User::class)->compte_activation($token_user);

        $notification='Votre compte à été validé';

        return $this->render('mon_compte/ValidationCompte.html.twig', [
            'notification' => $notification,
        ]);
    }
}
