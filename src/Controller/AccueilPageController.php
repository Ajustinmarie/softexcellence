<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccueilPageController extends AbstractController
{
    /**
     * @Route("/", name="accueil_page")
     */
    public function index(): Response
    {
        return $this->render('accueil_page/index.html.twig');
    }


     /**
     * @Route("/mention/legales", name="mention_legales")
     */
    public function legales(): Response
    {
        return $this->render('accueil_page/mentions_legales.html.twig');
    }
}
