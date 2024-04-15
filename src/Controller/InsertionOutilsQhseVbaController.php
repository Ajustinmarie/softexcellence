<?php

namespace App\Controller;

use App\Entity\OutilVba;
use App\Entity\Themes;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class InsertionOutilsQhseVbaController extends AbstractController
{


    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager=$entityManager;
    }



    /**
     * @Route("/insertion/outils/qhse/vba", name="insertion_outils_qhse_vba")
     */
    public function index(Request $request): Response
    {
        $notification=null;
        $themes=$this->entityManager->getRepository(Themes::class)->findAll();

        if ($request->isMethod('POST')) 
        {
            $nom_outil=htmlspecialchars($request->request->get('nom_outil'));
            $description=htmlspecialchars($request->request->get('description_outil'));
            $prix=htmlspecialchars($request->request->get('prix'));
            $themes=htmlspecialchars($request->request->get('theme'));
            $bouton_envoyer=htmlspecialchars($request->request->get('soumettre'));
            $video=htmlspecialchars($request->request->get('video_outil'));


            $documentation_pdf= $request->files->get('documentation_outil');         
            $image_outil= $request->files->get('image_outil');
            $fichier_pieces_jointes=$request->files->get('pieces_jointes');

          //  var_dump($image_outil);

          
         /*   if(!empty($nom_outil) AND !empty($image_outil) AND !empty($fichier_pieces_jointes)) */

         //   var_dump($nom_outil);

            if(!empty($nom_outil) AND !empty($documentation_pdf) AND !empty($image_outil) AND !empty($fichier_pieces_jointes) )
            {
                
                                        $taille_autorise = 2000000000;
                                        /*****************************IMAGE 1*****************************/                                                       
                                        $taille= $documentation_pdf['size'];
                                        $nom_fichier1 = $documentation_pdf['name'];
                                        $dossierTempo1 = $documentation_pdf['tmp_name']; 
                                        /*****************************IMAGE 2*****************************/
                                        /*
                                        $taille2= $video['size'];
                                        $nom_fichier2 = $video['name'];
                                        $dossierTempo2 = $video['tmp_name'];
                                        */
                                        /*****************************IMAGE 3*****************************/
                                        $taille3=$image_outil['size'];
                                        $nom_fichier3 = $image_outil['name'];
                                        $dossierTempo3 = $image_outil['tmp_name'];
                                        /*****************************IMAGE 4*****************************/
                                        $taille4=$fichier_pieces_jointes['size'];
                                        $nom_fichier4 = $fichier_pieces_jointes['name'];
                                        $dossierTempo4 = $fichier_pieces_jointes['tmp_name'];

                                        /*****************************IMAGE 1*****************************/
                                        $extension = strchr($nom_fichier1,'.');
                                        /*****************************IMAGE 2*****************************/
                                    /*    $extension2 = strchr($nom_fichier2,'.'); */
                                        /*****************************IMAGE 3*****************************/
                                        $extension3 = strchr($nom_fichier3,'.');
                                        /*****************************IMAGE 4*****************************/
                                        $extension4 = strchr($nom_fichier4,'.');

                                        $extension_autoriser = array('.png','.PNG','.jpg','.JPG','.pdf','.PDF','.mp4','.MP4','.xls','.xlsm','.xlsx','');


                                        /*****************************IMAGE 1*****************************/
                                        $nouveauNom1 = time();
                                        $nouveauNom1 = '1-'.$nouveauNom1.$extension;
                                        $dossierReception1 = 'uploads/'.$nouveauNom1;                                                        
                                        /*****************************IMAGE 2*****************************/
                                       /*
                                        $nouveauNom2 = time();
                                        $nouveauNom2 = '2-'.$nouveauNom2.$extension2;
                                        $dossierReception2 = 'uploads/'.$nouveauNom2;           
                                        */                                             
                                        /*****************************IMAGE 3*****************************/
                                        $nouveauNom3 = time();
                                        $nouveauNom3 = '3-'.$nouveauNom3.$extension3;
                                        $dossierReception3 = 'uploads/'.$nouveauNom3;
                                            /*****************************IMAGE 4*****************************/
                                        $nouveauNom4 = time();
                                        $nouveauNom4 = '4-'.$nouveauNom4.$extension4;
                                        $dossierReception4 = 'uploads/'.$nouveauNom4;

                                        if(!in_array($extension, $extension_autoriser) OR !in_array($extension3, $extension_autoriser) OR !in_array($extension4, $extension_autoriser) )
                                        {
                                            // echo'Extension Non autorisé!'; 
                                            $notification='Extension Non autorisé!';   
                                            
                                        }
                                        elseif ($taille>$taille_autorise OR $taille3>$taille_autorise OR $taille4>$taille_autorise)
                                        {      
                                            // echo 'Le fichier est trop volumineux!'; 
                                            $notification='Les fichiers sont trop volumineux!';  
                                            
                                        }
                                        else
                                        {
                                                        $testdeplacer= move_uploaded_file($dossierTempo1, $dossierReception1);
                                                      
                                                        $testdeplacer3= move_uploaded_file($dossierTempo3, $dossierReception3);
                                                        $testdeplacer4= move_uploaded_file($dossierTempo4, $dossierReception4);                                                                      

                                                       

                                                        $nom_outil_revise = html_entity_decode($nom_outil);
                                                        $description= html_entity_decode($description);
                                                        
                                                        $notification='Votre outil a bien été enregistré';
                                                
                                                        $insertion_outil_vba=$this->entityManager->getRepository(OutilVba::class)->insertion(
                                                        $nom_outil_revise, 
                                                        $description, 
                                                        $prix, 
                                                        $themes, 
                                                        $nouveauNom1,
                                                        $video,
                                                        $nouveauNom3, 
                                                        $nouveauNom4);
                                                        $notification='Votre outil a bien été enregistré';
                                            
                                                       
                                        }
            }
            else
            {
                $notification='Veuillez remplir tous les champs nécessaire: Nom, video, image, pièces jointes';
            }

         
        
        }


        return $this->render('mon_compte/InsertionOutilsQhseVba.html.twig', [
            'controller_name' => 'InsertionOutilsQhseVbaController',
            'themes'=>$themes,
            'notification'=>$notification
        ]);
    }
}
