<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OutilsQhseVbaController extends AbstractController
{
    /**
     * @Route("/outils/qhse/vba", name="outils_qhse_vba")
     */
    public function index(): Response
    {
        return $this->render('outils_qhse_vba/test.html.twig', [
            'controller_name' => 'OutilsQhseVbaController',
        ]);
    }
}
