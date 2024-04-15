<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\Security\Core\Authentication\AuthenticationManagerInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class EspaceLoginNouveauController extends AbstractController
{

    private $entityManager;
    private $authenticationManager;

    public function __construct(EntityManagerInterface $entityManager, AuthenticationManagerInterface $authenticationManager)
    {
        $this->entityManager=$entityManager;
        $this->authenticationManager = $authenticationManager;
     
    } 


    /**
     * @Route("/espace/login/nouveau", name="espace_login_nouveau")
     */
    public function index(AuthenticationUtils $authenticationUtils, Request $request, UserPasswordEncoderInterface $encoder, AuthenticationManagerInterface $authenticationManager, SessionInterface $session): Response
    {
        
         $notification=null;
         $email=null;
         $password=null;

        if ($request->isMethod('POST')) 
        {
                    // Récupérer les données du formulaire
                     $loginData = $request->request->all();

                     $email=$request->request->get('email');
                     $password=$request->request->get('password');

                    //   var_dump($loginData);  
                    // Récupérer l'utilisateur depuis la base de données (par exemple)
                      $userRepository = $this->getDoctrine()->getRepository(User::class);                      
                      $user = $userRepository->findOneByemail($email);
                    //   var_dump($loginData['password']);                      
                 
                    if(isset($user))
                   { 
                            if($user->getStatut()==true)
                            {
                              $isPasswordValid = $encoder->isPasswordValid($user, $loginData['password']);

                              if($isPasswordValid==true)
                              {
                                $email = $session->set('email',$email);
                                $nom=$session->set('nom',$user->getNom());
                                $prenom=$session->set('prenom',$user->getPrenom());
                                $numero=$session->set('numero',$user->getNumero());
                                $adresse=$session->set('adresse',$user->getAdresse());
                                $complement_adresse=$session->set('complement_adresse',$user->getComplementAdresse());
                                $ville=$session->set('ville',$user->getVille());
                                $pays=$session->set('Pays',$user->getPays());
                                $statut=$session->set('Statut',$user->getStatut());
                                $situation=$session->set('situation',$user->getSituation());
                                $roles=$session->set('Roles',$user->getRoles());
                                $id_user=$session->set('ID',$user->getId());

                                $password=$session->set('Password',$user->getPassword());

                                $token_user=$session->set('token_user',$user->getTokenUser());


                                

                             //   $user=$session->set('User',$user);

                                return $this->redirectToRoute('app_mon_compte'); 
                             //   $user->addRole('ROLE_USER');                                


                                  /***ESSAIS****/
                                  /*
                                  $authenticationManager = $this->get('security.authentication.manager');
                                  $token = new UsernamePasswordToken($email, $password, 'main');
                                  $authenticatedToken = $authenticationManager->authenticate($token);
                                  $this->get('security.token_storage')->setToken($authenticatedToken);
                                  $this->get('event_dispatcher')->dispatch(
                                    new InteractiveLoginEvent($this->getRequest(), $authenticatedToken)
                                  );
                                return $this->redirectToRoute('app_mon_compte');
                                */
                                  /***ESSAIS****/

                              }
                              else
                              {
                                $notification='Mot de passe érroné';
                              }
                            } 
                            else
                            {
                              $notification='Votre compte n\'est pas activé. Veuillez cliquer sur le lien d\'activation dans votre boîte mail.';
                            }                          
                   }
                   else
                   {
                      $notification='Adresse email inconnu';
                   }            
                   // var_dump($user->getStatut());
        }

        return $this->render('espace_login_nouveau/index.html.twig', [
            'controller_name' => 'EspaceLoginNouveauController',
            'notification'=>$notification,
             'email'=>$email,
             'password'=>$password            
        ]);
    }




    
}
