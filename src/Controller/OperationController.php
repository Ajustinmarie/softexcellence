<?php

namespace App\Controller;

use App\Entity\Payment;
use Doctrine\ORM\EntityManagerInterface;
use Omnipay\Omnipay;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Classe\Cart;
use App\Entity\OutilVba;

class OperationController extends AbstractController
{    
     private $passerelle;
     private $manager;     
     public function __construct(EntityManagerInterface $manager)
     {       
        $this->passerelle=Omnipay::create('PayPal_Rest');
        $this->passerelle->setClientId($_ENV['PAYPAL_CLIENT_ID']);
        $this->passerelle->setSecret($_ENV['PAYPAL_SECRET_KEY']);
        $this->passerelle->setTestMode(true);
        $this->manager=$manager;
     }

     /**
     * @Route("/payment", name="app_payment")
     */
    public function payment(Request $request): Response
    {
       $token=$request->request->get('token');

       if(!$this->isCsrfTokenValid('myform',$token))
       {
            return new Response('Operation non autorisée', Response::HTTP_BAD_REQUEST,
            ['content-type'=>'text/plain']);
       }

       $response=$this->passerelle->purchase(array(
        'amount'=>$request->request->get('amount'),
        'currency'=>$_ENV['PAYPAL_CURRENCY'],
        'returnUrl'=>'https://127.0.0.1:8000/success',
        'cancelUrl'=>'https://127.0.0.1:8000/error'
      
        ))->send();
     
        try {
            if($response->isRedirect())
            {
                $response->redirect();
            }

            else
            {
                return $response->getMessage();
            }
        } catch (\Throwable $th) {
            
            return $th->getMessage();
        }      
       
        return $this->render('operation/index.html.twig');
    }


    //Page de succès de la transaction

     /**
     * @Route("/success", name="app_success")
     */
    public function success(Request $request, SessionInterface $session, Cart $cart): Response
    {  
            if($request->query->get('paymentId') && $request->query->get('PayerID'))
            {
                              
                $operation=$this->passerelle->completePurchase(array(
                    'payer_id'=>$request->query->get('PayerID'),
                    'transactionReference'=>$request->query->get('paymentId')
                 ));

                 $response=$operation->send();

                 if($response->isSuccessful())
                 {
                                        $data=$response->getData();

                                        $paymentId = $request->query->get('paymentId');
                                        $payer_id = $request->query->get('PayerID');

                                        $payments_status=$data['state'];
                                      //  $purchased_at=new \DateTime();
                                      $purchased_at='2024-04-06';
                                        $email=$data['payer']['payer_info']['email'];  
                                        

                                        $numero_commande_session = $session->get('numero_commande_session');
                                        if(!$numero_commande_session)
                                        {
                                            return $this->redirectToRoute('outils_qhse_vba');
                                        }                                      

                                        /* MAIL */                       
                                        $destinataire = "destinataire@example.com";
                                        $sujet = "Mail de confirmation d'achat ";
                                        $message = "Merci pour votre achat de références $numero_commande_session. Vous recevrez votre facture sous peu";
                                        $message .= "<br/><br/>Sincérement,<br/>L'équipe de softexcellence";
                                        $headers = "From: votre_email@example.com\r\n";
                                        $headers .= "Reply-To: votre_email@example.com\r\n";
                                        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";                         
                                        /* MAIL */
                                        
                                        $verif_email_achat=$this->manager->getRepository(OutilVba::class)->verif_commande($numero_commande_session);

                                        $boolean_verif_achat=$verif_email_achat[0]['commande_paye'];                     

                                        if($boolean_verif_achat==0)
                                        {
                                                              mail($destinataire, $sujet, $message, $headers);   
                                                       
                                                            
                                                             $achat_comfirmer_bdd=$this->manager->getRepository(OutilVba::class)->achat_confirmer($numero_commande_session, $paymentId, $payer_id, $payments_status, $purchased_at, $email);                 
                                                                
                                                            //    dd($achat_comfirmer_bdd);
                                                                
                                                                $cart->remove();

                                                                return $this->render('operation/success.html.twig',
                                                                [
                                                                  'message'=>'Votre paiement a été un succès, voici l\'id de votre transaction:' .$payer_id
                                                                ]
                                                                );
                                        }            
                               
                 }
                 else
                 {
                    return $this->render('operation/success.html.twig',
                      [
                        'message'=>'Le paiement a échoué !'
                      ]
                      );
                 }
            }

            else
            {
             return $this->render('operation/success.html.twig',
                   [
                     'message'=>'l\'utilisateur a annulé son paiement'
                   ]
                   );
            }


            return $this->render('operation/success.html.twig',
            [
              'message'=>'Une erreure est survenue'
            ]
            );

    }



    //Page d'error de la transaction
     /**
     * @Route("/error", name="app_error")
     */
    public function error(): Response
    {
        return $this->render('Operation/success.html.twig',
              [
                'message'=>'le paiement a échoué'
              ]
              );
    }
}
