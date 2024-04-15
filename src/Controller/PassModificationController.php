<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\PassModificationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class PassModificationController extends AbstractController
{



    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
          $this->entityManager = $entityManager;
    }

    /**
     * @Route("/moncompte/modification", name="app_pass_modification")
     */
    public function index(Request $request, UserPasswordEncoderInterface $encoder, SessionInterface $session): Response
    {

        $notification=null;
      //  $user=$this->getUser();
         
        $user = new User();


     //   $session->get('email',$email);

        $nom=$session->get('nom');
        $prenom=$session->get('prenom');
        $email=$session->get('email');
        $numero=$session->get('numero');
        $adresse=$session->get('adresse');
        $complement_adresse=$session->get('complement_adresse');
        $Pays=$session->get('Pays');
        $ville=$session->get('ville');
        $situation=$session->get('situation');
        $password=$session->get('Password');        
        $token_user=$session->get('token_user');
        $password=$session->get('Password');   
        $id_user=$session->get('ID');    
        
        /* identificant */
        $id_user=$session->get('ID');
        /* identificant */

      
        $user->setNom($nom);
        $user->setPrenom($prenom);
        $user->setNumero($numero);
        $user->setAdresse($adresse);
        $user->setEmail($email);
        $user->setComplementAdresse($complement_adresse);     
        $user->setVille($ville);
        $user->setPays($Pays);
        $user->setSituation($situation);        
        $user->setTokenUser($token_user);
        $user->setPassword($password);


       


       


        $form=$this->createForm(PassModificationType::class, $user);
        $form->handleRequest($request);


        if($form->isSubmitted() && $form->isValid())
        {
         $old_password=$form->get('old_password')->getData();
           
           if($encoder->isPasswordValid($user, $old_password))
           {             
                 $new_password= $encoder->encodePassword($user,$form->get('new_password')->getData());
 
                 $password=$user->setPassword($new_password);

                 $password_finale=$password->getPassword();

                $this->entityManager->getRepository(User::class)->modif_password($password_finale, $id_user);
                 
                 // var_dump($password->getPassword());
                 // $this->entityManager->persist($password);
                 // $this->entityManager->flush();


                  $notification="Votre mot de passe a été mis à jour";
           }
           else
           {
                 $notification="La mise à jour n'a pas été possible le mot de passe actuel n'est pas correct";
           }
       }


        return $this->render('mon_compte/pass_modification.html.twig', [
            'controller_name' => 'PassModificationController',
            'form' => $form->createView(),
            'notification'=>$notification
        ]);
    }
}
