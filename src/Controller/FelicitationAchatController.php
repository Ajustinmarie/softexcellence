<?php

namespace App\Controller;

use App\Classe\Cart;
use App\Entity\OutilVba;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class FelicitationAchatController extends AbstractController
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
       
         $this->entityManager=$entityManager;
    }

    /**
     * @Route("/felicitation/achat", name="felicitation_achat")
     */
    public function index(SessionInterface $session, Cart $cart): Response
    {
     
                $numero_commande_session = $session->get('numero_commande_session');

                if(!$numero_commande_session)
                {
                    return $this->redirectToRoute('outils_qhse_vba');
                }      
                
                $destinataire = "destinataire@example.com";
                $sujet = "Mail de confirmation d'achat ";
                $message = "Merci pour votre achat de la référence $numero_commande_session. Vous recevrez votre facture sous 24h";
                $message .= "<br/><br/>Sincérement,<br/>L'équipe de softexcellence";

                $headers = "From: votre_email@example.com\r\n";
                $headers .= "Reply-To: votre_email@example.com\r\n";
                $headers .= "Content-Type: text/html; charset=UTF-8\r\n";       
                    
            $verif_email_achat=$this->entityManager->getRepository(OutilVba::class)->verif_commande($numero_commande_session);

            $boolean_verif_achat=$verif_email_achat[0]['commande_paye'];
            
            if($boolean_verif_achat==0)
            {
                mail($destinataire, $sujet, $message, $headers);   
                $achat_comfirmer_bdd=$this->entityManager->getRepository(OutilVba::class)->achat_confirmer($numero_commande_session);                 
                $cart->remove();
            }
            else
            {
                return $this->redirectToRoute('outils_qhse_vba');
            }

                

                return $this->render('felicitation_achat/index.html.twig', [
                    'numero_commande_session' => $numero_commande_session,
                ]);

    }
}
