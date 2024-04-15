<?php

namespace App\Repository;

use App\Classe\Cart;
use App\Entity\OutilVba;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<OutilVba>
 *
 * @method OutilVba|null find($id, $lockMode = null, $lockVersion = null)
 * @method OutilVba|null findOneBy(array $criteria, array $orderBy = null)
 * @method OutilVba[]    findAll()
 * @method OutilVba[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OutilVbaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OutilVba::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(OutilVba $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(OutilVba $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

   
    public function insertion($nom_outil_revise, $description, $prix, $themes, $nouveauNom1,$nouveauNom2,$nouveauNom3, $nouveauNom4)
    {   
      
        $conn = $this->getEntityManager()->getConnection();
        $sql = "INSERT INTO outil_vba (nom_outil, description, prix, documentation, video, image, pieces_jointes, themes_id) 
        VALUES (:nom_outil, :description, :prix, :documentation, :video, :image, :pieces_jointes, :themes_id)";


$stmt = $conn->prepare($sql);
$stmt->bindValue('nom_outil', $nom_outil_revise);
$stmt->bindValue('description', $description);
$stmt->bindValue('prix', $prix);
$stmt->bindValue('documentation', $nouveauNom1);
$stmt->bindValue('video', $nouveauNom2);
$stmt->bindValue('image', $nouveauNom3);
$stmt->bindValue('pieces_jointes', $nouveauNom4);
$stmt->bindValue('themes_id', $themes);

$stmt->execute();

}


public function validation_panier( $id_user, $dateAujourdhui, $commade_paye, $panier,$numero_commande )
    { 
        $conn = $this->getEntityManager()->getConnection();        

         foreach ($panier as $paniers) {            
            /*
            var_dump($dateAujourdhui);
            var_dump($id_user);
            var_dump($paniers['id']->getPrix());
            var_dump($commade_paye);
            var_dump($paniers['id']->getid());     
            */ 
         $sql = "INSERT INTO commande_detail (id_utilisateur, 
                                              date_creation, 
                                              id_outil_vba, 
                                              quantite, 
                                              prix, 
                                              total, 
                                              commande_paye, 
                                              numero_commande)        
                                      VALUES (:id_utilisateur, 
                                              :date_creation,
                                              :id_outil_vba, 
                                              :quantite, 
                                              :prix, 
                                              :total, 
                                              :commande_paye,
                                              :numero_commande)";
       

        $stmt = $conn->prepare($sql);
        $stmt->bindValue('id_utilisateur', $id_user);
        $stmt->bindValue('date_creation', $dateAujourdhui);
        $stmt->bindValue('id_outil_vba', $paniers['id']->getid());
        $stmt->bindValue('quantite', 1);
        $stmt->bindValue('prix', $paniers['id']->getPrix());
        $stmt->bindValue('total', $paniers['id']->getPrix());
        $stmt->bindValue('commande_paye', $commade_paye); 
        $stmt->bindValue('numero_commande', $numero_commande); 
        $stmt->execute();

       }
        
    }

    public function achat_confirmer($numero_commande_session, $paymentId, $payer_id, $payments_status, $purchased_at, $email)
    { 

                 if(!$numero_commande_session)
                 {
                    return $this->redirectToRoute('outils_qhse_vba');
                 }

                 $conn = $this->getEntityManager()->getConnection();                        
                 $sql = "UPDATE commande_detail SET 
                 commande_paye = 1,
                 payment_id = :payment_id,
                 payer_id = :payer_id,
                 payment_status = :payment_status,
                 purchased_at = :purchased_at,
                 payer_email = :payer_email                  
             WHERE 
                 numero_commande = :numero_commande           
                 ";                
                
                     $stmt = $conn->prepare($sql);
                     $stmt->bindValue('numero_commande', $numero_commande_session);
                     $stmt->bindValue('payment_id', $paymentId);
                     $stmt->bindValue('payer_id', $payer_id);
                     $stmt->bindValue('payment_status', $payments_status);
                     $stmt->bindValue('purchased_at', $purchased_at);
                     $stmt->bindValue('payer_email', $email);
                     $stmt->execute();             
   
    }

/* Commande pour verifier */
    public function verif_commande($numero_commande_session)
    { 

                 if(!$numero_commande_session)
                 {
                    return $this->redirectToRoute('outils_qhse_vba');
                 }

                 $conn = $this->getEntityManager()->getConnection();                        
                 $sql = " SELECT * FROM commande_detail WHERE numero_commande=$numero_commande_session LIMIT 1  ";    
                
                 $stmt = $conn->prepare($sql);
                 $resultSet = $stmt->executeQuery();                   
                  
                 // returns an array of arrays (i.e. a raw data set)
                 return $resultSet->fetchAllAssociative(); 
    }

    /* Commande pour determiner le nombre d'outil q'une personne possède */
    public function outil_user($id_user)
    { 

                 if(!$id_user)
                 {
                    return $this->redirectToRoute('outils_qhse_vba');
                 }

                 $conn = $this->getEntityManager()->getConnection();                        
                 $sql = " SELECT DISTINCT(id_outil_vba) FROM commande_detail WHERE id_utilisateur=$id_user AND commande_paye=1 ";    
                
                 $stmt = $conn->prepare($sql);
                 $resultSet = $stmt->executeQuery();                   
                  
                 // returns an array of arrays (i.e. a raw data set)
                 return $resultSet->fetchAllAssociative();
   
    }


        /* Fonction qui va rechercher avec une liste (1,2,3,.....) les outils que l'utilisateur a payer */
        public function liste_outil_user($id_user, $liste)
        {  
                     if(!$id_user)
                     {
                        return $this->redirectToRoute('outils_qhse_vba');
                     }                   
    
                     $conn = $this->getEntityManager()->getConnection();                        
                     $sql = " SELECT *
                              FROM outil_vba
                              WHERE id IN ($liste)
                            ";    
                    
                     $stmt = $conn->prepare($sql);
                     $resultSet = $stmt->executeQuery(); 

                     // returns an array of arrays (i.e. a raw data set)
                     return $resultSet->fetchAllAssociative();  
        }




              /* Fonction qui va rechercher si l'iddentifiant vba est payée par l'utilisateur */
              public function verif_id_paye($id_vba, $id_user)
              {  
                            
                if(empty($id_user))
                {
                    $id_user=0;
                }
          
                           $conn = $this->getEntityManager()->getConnection();                        
                           $sql = " SELECT *
                                    FROM commande_detail
                                    WHERE id_outil_vba = $id_vba
                                    AND commande_paye = 1
                                    AND id_utilisateur=$id_user
                                  ";    
                          
                           $stmt = $conn->prepare($sql);
                           $resultSet = $stmt->executeQuery(); 
      
                           // returns an array of arrays (i.e. a raw data set)
                           return $resultSet->fetchAllAssociative();  
              }


    // /**
    //  * @return OutilVba[] Returns an array of OutilVba objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?OutilVba
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
