<?php

namespace App\Controller;

use App\Entity\ResetPassword;
use App\Entity\User;
use App\Form\ResetPasswordType;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class ResetPasswordController extends AbstractController
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager=$entityManager;
    }

    /**
     * @Route("/mot-de-passe-oublie", name="reset_password")
     */
    public function index(Session $session, Request $request): Response
    {
        $email=$session->get('email');
      //  var_dump($email);
        if(!empty($email))
        {
            return $this->redirectToRoute('accueil_page');
        }

      if($request->get('email'))
      {
          //  dd($request->get('email'));
         $user=$this->entityManager->getRepository(User::class)->findOneByEmail($request->get('email'));
         
        if($user)
        {
            // 1: Enregister en base la demande de reset_password avec user, token, createdAd
            $reset_password = new ResetPassword();
            $reset_password->setUser($user);
            $reset_password->setToken(uniqid());
            $reset_password->setCreatedAt( new \DateTime());
            $this->entityManager->persist($reset_password);
            $this->entityManager->flush();
            
            // 2: Envoyer un email à l'utilisateur avec un lien lui permettant de mettre a jour son mot de passe
            $url = $this->generateUrl('update_password', [
                'token' => $reset_password->getToken()
            ]);

            $content = "Bonjour ".$user->getPrenom()."<br/>Vous avez demandé à réinitialiser votre mot de passe sur le site de softexcellence.<br/><br/>";
            $content .= "Merci de bien vouloir cliquer sur le lien suivant pour <a href='".$url."'>mettre à jour votre mot de passe</a>.";

            $destinataire = $request->get('email');
            $sujet = "Réinitialisation mot de passe boutique";
            $message = "Bonjour".$user->getPrenom()." <br/> Veuillez cliquer sur le lien d'activation pour activer vôtre compte <a href='$url'>Activation</a>.";
            $message .= "<br/><br/>Cordialement,<br/>Votre Nom";

            $headers = "From: votre_email@example.com\r\n";
            $headers .= "Reply-To: votre_email@example.com\r\n";
            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

            // Envoi de l'e-mail
            mail($destinataire, $sujet,  $content, $headers);   
            $this->addFlash('notice','Vous allez recevoir dans quelques secondes un mail avec la procédure pour réintialiser votre mot de passe');

        }
        else
        {
             $this->addFlash('notice','Cette adresse email est inconnue');
        }

      }

        return $this->render('reset_password/index.html.twig');
    }




     /**
     * @Route("/mot-de-passe-oublie/{token}", name="update_password")
     */
    public function update($token, Request $request, UserPasswordEncoderInterface $encoder)
    {       
            $reset_password= $this->entityManager->getRepository(ResetPassword::class)->findOneByToken($token);

            if(!$reset_password)
            {
                return $this->redirectToRoute('reset_password');
            }

            $now=new \DateTime();

            if($now>$reset_password->getCreatedAt()->modify('+3 hour'))
            {        
                // modifier mon mot de passe
                $this->addFlash('notice','Votre demande de mot de passe a expiré. Merci de la renouveller');
                return $this->redirectToRoute('reset_password');
            }

            // dd($reset_password);
            // Rendre une vue avec mot de passe et confirmer votre mot de passe.
           
           
            $form = $this->createForm(ResetPasswordType::class);
            $form->handleRequest($request);

            if($form->isSubmitted() && $form->isValid())
            {   
                 $new_pwd=$form->get('new_password')->getData();
                 $password = $encoder->encodePassword($reset_password->getUser(), $new_pwd);
                // Flush en base de données
                 $reset_password->getUser()->setPassword($password);
                // redirection de l'utilisateur vers la page
                 $this->entityManager->flush();
                 $this->addFlash('notice','Votre mot de passe à bien été mise à jour');
                 return $this->redirectToRoute('espace_login_nouveau');
            }

           
            return $this->render('reset_password/update.html.twig',[
                'form' => $form->createView()
            ]);
           
            







    }






}
