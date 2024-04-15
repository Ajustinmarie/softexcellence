<?php

namespace App\Controller;

use App\Entity\OutilVba;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class OutilsQhseVbaController extends AbstractController
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager){
       $this->entityManager = $entityManager;
    }

    /**
     * @Route("/outils/qhse/vba", name="outils_qhse_vba")
     */
    public function index(SessionInterface $session): Response
    {
        $notification=null;
       $produit_vba_user_liste=null;


       $produit_vba=$this->entityManager->getRepository(OutilVba::class)->findAll();

       if(empty($produit_vba))
       {
          $notification='Aucun outil est disponible pour le moment';
       }

       $id_user=$session->get('ID');

       if(!empty($id_user))
       {
        $produit_vba_user_liste=$this->entityManager->getRepository(OutilVba::class)->outil_user($id_user);
       }

      

       return $this->render('outils_qhse_vba/index.html.twig', [
            'produit_vba' => $produit_vba,
            'produit_vba_user_liste'=> $produit_vba_user_liste,
            'notification'=>$notification
        ]);
    }



    /**
     * @Route("/outils_detail/qhse/vba/{id}", name="outils_qhse_vba_detail")
     */
    public function detail($id, SessionInterface $session): Response
    {

       $verif_id_vba_paye_finale=null;

       $produit_vba_detail=$this->entityManager->getRepository(OutilVba::class)->findOneById($id);  
       
       $id_vba=$produit_vba_detail->getId();

       $id_user=$session->get('ID');

       $verif_id_vba_paye=$this->entityManager->getRepository(OutilVba::class)->verif_id_paye($id_vba, $id_user); 

       if(!empty($verif_id_vba_paye))
       {
           $verif_id_vba_paye_finale=$verif_id_vba_paye[0]['commande_paye'];
       }
   

        return $this->render('outils_qhse_vba/outils_vba_detail.html', [
            'produit_vba_detail' => $produit_vba_detail,
            'verif_id_vba_paye_finale'=> $verif_id_vba_paye_finale 
        ]);
    }
}
