<?php

namespace App\Repository;

use App\Entity\Discussion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Query\Expr\Join;

/**
 * @method Discussion|null find($id, $lockMode = null, $lockVersion = null)
 * @method Discussion|null findOneBy(array $criteria, array $orderBy = null)
 * @method Discussion[]    findAll()
 * @method Discussion[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DiscussionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Discussion::class);
    }

    // /**
    //  * @return Discussion[] Returns an array of Discussion objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Discussion
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function DiscussionFindByResum($word){
        //on récupère le mot
        //createQueryBuilder permet de récupérer le constructeur de requete SQL
        $queryBuilder = $this->createQueryBuilder('discussion');
        //récupérer le mot entré dans la BDD et faire de la sécurité
        $query = $queryBuilder->select('discussion')
             //la requete SQL avec une clause WHERE et le placeholder correspondant
            ->where('discussion.first_post LIKE :word')
            //la sécurité pour empecher les injections SQL en remplaçant le placeholder par
            //la vraie valeur
            ->setParameter('word', '%'.$word.'%')
            //on récupère le résultat
            ->getQuery();
        //on attribut à une variable le résultat de la commande précédante
        $discussions = $query->getResult();
        //on retourne le résulta
        return $discussions;
    }
}
