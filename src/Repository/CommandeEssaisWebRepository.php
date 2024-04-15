<?php

namespace App\Repository;

use App\Entity\CommandeEssaisWeb;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CommandeEssaisWeb>
 *
 * @method CommandeEssaisWeb|null find($id, $lockMode = null, $lockVersion = null)
 * @method CommandeEssaisWeb|null findOneBy(array $criteria, array $orderBy = null)
 * @method CommandeEssaisWeb[]    findAll()
 * @method CommandeEssaisWeb[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommandeEssaisWebRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CommandeEssaisWeb::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(CommandeEssaisWeb $entity, bool $flush = true): void
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
    public function remove(CommandeEssaisWeb $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }


    public function verif_id_web($id, $id_user)    
    {         
                $conn = $this->getEntityManager()->getConnection();
                $sql = "SELECT * FROM commande_essais_web WHERE id_outil_web=$id  AND user=$id_user";   
                $stmt = $conn->prepare($sql);
                $resultSet = $stmt->executeQuery();                  
                // returns an array of arrays (i.e. a raw data set)
                return $resultSet->fetchAllAssociative(); 
    }
    
    /*
    public function verif_id_web($id_outil_web)    
    {         
                $conn = $this->getEntityManager()->getConnection();
                $sql = "SELECT * FROM commande_essais_web WHERE id_outil_web=$id_outil_web LIMIT 1";   
                $stmt = $conn->prepare($sql);
                $resultSet = $stmt->executeQuery();                  
                // returns an array of arrays (i.e. a raw data set)
                return $resultSet->fetchAllAssociative(); 
    }
    */



    public function insertion_commande_web($id_user, $id, $date, $email, $nom)    
      {         
                $conn = $this->getEntityManager()->getConnection();
                $sql = "INSERT INTO commande_essais_web (user, id_outil_web, date, email, nom) 
                VALUES (:user, :id_outil_web, :date, :email, :nom)";
                $stmt = $conn->prepare($sql);   
                $stmt->bindValue('user', $id_user);
                $stmt->bindValue('id_outil_web', $id);
                $stmt->bindValue('date', $date);
                $stmt->bindValue('email', $email);
                $stmt->bindValue('nom', $nom);      
                $stmt->execute();
      }

    // /**
    //  * @return CommandeEssaisWeb[] Returns an array of CommandeEssaisWeb objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CommandeEssaisWeb
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
