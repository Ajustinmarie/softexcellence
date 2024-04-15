<?php

namespace App\Classe;

use App\Entity\OutilVba;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class Cart
{
     private $session;
     private $entityManager;

     public function __construct(SessionInterface $session, EntityManagerInterface $entityManager)
     {
          $this->session=$session;
          $this->entityManager=$entityManager;
     }


      public function add($id)
      {
                $cart=$this->session->get('cart',[]);

                if(!empty($cart[$id]))
                {
                   $cart[$id]=1;
                }
                else
                {
                  $cart[$id]=1;
                }
               

                $this->session->set('cart', $cart);
      }


      public function get()
      {
        return $this->session->get('cart');
      }


      public function remove()
      {
            return $this->session->remove('cart');
      }


      public function delete($id)
      {
        $cart=$this->session->get('cart',[]);
        unset($cart[$id]);
        return  $this->session->set('cart', $cart);
      }

      public function getFull()
      {
        $cartComplete = [];

        if($this->get()){

                foreach($this->get() as $id => $quantity) {
                $article_object=$this->entityManager->getRepository(OutilVba::class)->findOneById($id);
                
                if(!$article_object)
                {
                    $this->delete($id);
                    continue;
                }

                $cartComplete[]= 
                [
                'id' =>$article_object,
                'quantity' => $quantity
                ];
        }

            
        }
        
        return   $cartComplete;
      }

}