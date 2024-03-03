<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RecapitulatifPanierController extends AbstractController
{
    /**
     * @Route("/recapitulatif/panier", name="recapitulatif_panier")
     */
    public function index(): Response
    {
        return $this->render('panier/recapitulatif.html.twig', [
            'controller_name' => 'RecapitulatifPanierController',
        ]);
    }
}
