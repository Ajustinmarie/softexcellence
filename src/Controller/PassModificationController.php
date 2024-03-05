<?php

namespace App\Controller;

use App\Form\PassModificationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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
    public function index(Request $request, UserPasswordEncoderInterface $encoder): Response
    {

        $notification=null;
        $user=$this->getUser();
        $form=$this->createForm(PassModificationType::class, $user);
        $form->handleRequest($request);


        if($form->isSubmitted() && $form->isValid())
        {
         $old_password=$form->get('old_password')->getData();
           
           if($encoder->isPasswordValid($user, $old_password))
           {             
                 $new_password= $encoder->encodePassword($user,$form->get('new_password')->getData());
 
                 $password=$user->setPassword($new_password);
 
                  $this->entityManager->persist($password);
                  $this->entityManager->flush();
                  $notification="Votre mot de passe a été mis a jour";
           }
           else
           {
                 $notification="La mise à jour n\'a pas été possible";
           }
       }


        return $this->render('mon_compte/pass_modification.html.twig', [
            'controller_name' => 'PassModificationController',
            'form' => $form->createView(),
            'notification'=>$notification
        ]);
    }
}
