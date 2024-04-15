<?php

namespace App\Controller;

use App\Entity\CommandeEssaisWeb;
use App\Entity\OutilWeb;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;


class OutilsQhseWebController extends AbstractController
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {   
         $this->entityManager=$entityManager;
    }


    /**
     * @Route("/outils/qhse/web", name="outils_qhse_web")
     */
    public function index(): Response
    {
        $notification=null;
        $liste_outil_web=$this->entityManager->getRepository(OutilWeb::class)->findAll();

      

        if(empty($liste_outil_web))
        {
            $notification='Aucune solution est disponible pour le moment';
        }
       
        
       // var_dump($liste_outil_web);

        return $this->render('outils_qhse_web/test.html.twig', [
            'controller_name' => 'OutilsQhseWebController',
            'liste_outil_web'=> $liste_outil_web,
            'notification'=> $notification
        ]);
    }


     /**
     * @Route("/outils/qhse/web/demande_periode_essais/{id}", name="outils_qhse_web_periode_essais")
     */
    public function insertion_commande_web($id, SessionInterface $session): Response
    {
        $notification=null;
        $email = $session->get('email');
        $date= date("Y-m-d");
        $id_user=$session->get('ID');
        $nom=$session->get('nom');

     //    $verif_id_user=$this->entityManager->getRepository(CommandeEssaisWeb::class)->findOneByUser($id_user);

         $verif_id_outil_web=$this->entityManager->getRepository(CommandeEssaisWeb::class)->verif_id_web($id, $id_user);    
         

       /*  $commande_essais=$this->entityManager->getRepository(CommandeEssaisWeb::class)->insertion_commande_web($id_user, $id, $date, $email, $nom);
         $notification='Votre demande est pris en compte nous vous ferons un retour sous 24h'; */
      
         
          if(empty($verif_id_outil_web))
          {
                    $notification='Votre demande est pris en compte nous vous ferons un retour sous 24h';
                    $commande_essais=$this->entityManager->getRepository(CommandeEssaisWeb::class)->insertion_commande_web($id_user, $id, $date, $email, $nom);
          }
          else
          {
                 $notification='Votre demande a déja été pris en compte nous vous ferons un retour sous 24h merci de votre patience';
          }

        


       // var_dump($id);
        return $this->render('outils_qhse_web/periode_essais.html.twig', [
            'controller_name' => 'OutilsQhseWebController',
             'notification'=>$notification
        ]);
    }
}
