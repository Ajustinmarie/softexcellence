<?php

namespace App\Controller;

use App\Entity\OutilVba;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;

class VoirOutilVbaUserController extends AbstractController
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager){
       $this->entityManager = $entityManager;
    }

    /**
     * @Route("/voir/outil/vba/user", name="voir_outil_vba_user")
     */
    public function index(Session $session): Response
    {
       
        $id_user=$session->get('ID');

        $produit_vba_user_liste=$this->entityManager->getRepository(OutilVba::class)->outil_user($id_user);

       
        if(empty($produit_vba_user_liste))
        {
            return $this->redirectToRoute('voir_commandes');
         
        }
      

        
     //   $liste = implode(",", $produit_vba_user_liste); 

            $output = [];

            foreach ($produit_vba_user_liste as $item) {
                $output[] = $item['id_outil_vba'];
            }
            
            $liste = implode(',', $output);


            $produit_vba=$this->entityManager->getRepository(OutilVba::class)->liste_outil_user($id_user, $liste);
       

        return $this->render('voir_outil_vba_user/index.html.twig', [
             'produit_vba' => $produit_vba,
             
        ]);
    }



      /**
     * @Route("/voir/commmandes/", name="voir_commandes")
     */
    public function commande(Session $session): Response
    {       
                        

                return $this->render('voir_outil_vba_user/aucune_commande.html.twig');
    }

}
