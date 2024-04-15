<?php

namespace App\Controller;

use App\Classe\Cart;
use App\Entity\OutilVba;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class PanierController extends AbstractController
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager=$entityManager;
    }

    /**
     * @Route("/panier", name="app_panier")
     */
    public function index(Cart $cart): Response
    {
       // dd($cart->get()); 
       //   dd($cartComplete);
        return $this->render('panier/index.html.twig', [
            'cart' =>$cart->getFull()
        ]);
    }

     /**
     * @Route("/panier/add/{id}", name="add_to_panier")
     */
    public function add(Cart $cart, $id): Response
    {
         $cart->add($id);

         return $this->redirectToRoute('app_panier');
    }


     /**
     * @Route("/panier/remove", name="remove_to_panier")
     */
    public function remove(Cart $cart): Response
    {
         $cart->remove();
         return $this->redirectToRoute('outils_qhse_vba');
    }


         /**
     * @Route("/panier/delete/{id}", name="delete_to_cart")
     */
    public function delete(Cart $cart, $id): Response
    {
         $cart->delete($id);
         return $this->redirectToRoute('app_panier');
    }


}
