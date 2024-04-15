<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\InscrpitonFormulaireType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authenticator\Passport\UserPassportInterface;

class InscriptionController extends AbstractController
{



    private $entityManager;

            public function __construct(EntityManagerInterface $entityManager)
            {
                $this->entityManager=$entityManager;
            }


            /**
             * @Route("/inscription", name="inscription")
             */
            public function index(Request $request, UserPasswordEncoderInterface $encoder): Response
            {
                $user=new User;
                $form=$this->createForm(InscrpitonFormulaireType::class, $user);
                $form->handleRequest($request);
                $notification=null;

                if($form->isSubmitted() and $form->isValid())
                {
                    $email=$form->get('email')->getData();
                    $prenom=$form->get('prenom')->getData();
                    $token_user=$form->get('TokenUser')->getData();

                    $verif_email=$this->entityManager->getRepository(User::class)->findByemail($email);

                    if(empty($verif_email))
                    {
                        $user=$form->getData();
                        $password=$user->getPassword();
                        $user_crypt_password=$encoder->encodePassword($user,$password);    
                        $user->setPassword($user_crypt_password);         
                        $this->entityManager->persist($user);
                        $this->entityManager->flush();
                        $notification='Le compte à bien été crée';     
                        
                        $url="127.0.0.1:8000/validation/compte/connexion/$token_user";
                     //   $lien_crypte = md5($url);
                        
                        $destinataire = "destinataire@example.com";
                        $sujet = "Mail d'activation softexcellence";
                        $message = "Bonjour $prenom <br/> Veuillez cliquer sur le lien d'activation pour activer vôtre compte <a href='$url'>activation</a>.";
                        $message .= "<br/><br/>Cordialement,<br/>Votre Nom";

                        $headers = "From: no-reply@softexcellence.com\r\n";
                        $headers .= "Reply-To: no-reply@softexcellence.com\r\n";
                        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

                        // Envoi de l'e-mail
                        mail($destinataire, $sujet, $message, $headers);   

                        $notification='Nous avons pris en compte votre inscription. Vous allez recevoir un e-mail d\'activation.';

                    };
                }

                return $this->render('inscription/index.html.twig', [
                    'form'=>$form->createView(),
                    'notification'=>$notification
                ]);
            }
}

