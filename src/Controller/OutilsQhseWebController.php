<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OutilsQhseWebController extends AbstractController
{
    /**
     * @Route("/outils/qhse/web", name="outils_qhse_web")
     */
    public function index(): Response
    {
        return $this->render('outils_qhse_web/test.html.twig', [
            'controller_name' => 'OutilsQhseWebController',
        ]);
    }
}
