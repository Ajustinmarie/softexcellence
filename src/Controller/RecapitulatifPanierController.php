<?php

namespace App\Controller;

use App\Classe\Cart;
use App\Entity\OutilVba;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class RecapitulatifPanierController extends AbstractController
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
       
         $this->entityManager=$entityManager;
    }


    /**
     * @Route("/recapitulatif/panier", name="recapitulatif_panier")
     */
    public function index(Cart $cart, SessionInterface $session): Response
    {

             /* id_utilisateur */
             $id_user = $session->get('ID');

              /* date_creation */
              $dateAujourdhui = date('Y-m-d');

                /* id_outil_vba */
              $panier=$cart->getFull();

               /* quantite */
               /* prix */
                /* total */
                /* commande_paye */                
               // $commade_paye=generateRandomNumber();
              
               $commade_paye=0;
                
                 

                /* numero_commande */
                function generateRandomNumber() {
                    $randomNumber = '';
                    for ($i = 0; $i < 9; $i++) {
                        $randomNumber .= mt_rand(0, 9); // Génère un chiffre aléatoire entre 0 et 9 et l'ajoute à la chaîne
                    }
                    return $randomNumber;
                }
                $numero_commande=generateRandomNumber();

                $numero_commande_session=$session->set('numero_commande_session',$numero_commande);

                $article_object=$this->entityManager->getRepository(OutilVba::class)->validation_panier($id_user, $dateAujourdhui, $commade_paye, $panier, $numero_commande);


        return $this->render('panier/recapitulatif.html.twig', [
            'cart' =>$cart->getFull(),
        ]);
    }
}
