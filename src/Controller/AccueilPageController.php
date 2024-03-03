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
}
