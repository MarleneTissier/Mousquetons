<?php

namespace App\Repository;

use App\Entity\Profil;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Profil|null find($id, $lockMode = null, $lockVersion = null)
 * @method Profil|null findOneBy(array $criteria, array $orderBy = null)
 * @method Profil[]    findAll()
 * @method Profil[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProfilRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Profil::class);
    }

    // /**
    //  * @return Profil[] Returns an array of Profil objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Profil
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    public function ByUser($idUser)
    {
        //on récupère id
        //createQueryBuilder permet de récupérer le constructeur de requete SQL
        $queryBuilder = $this->createQueryBuilder('profil');
        $query = $queryBuilder
            ->select('profil')
            //la requete SQL avec une clause WHERE
            ->where('profil.user = :idUser')
            //la sécurité pour empecher les injections SQL en remplaçant le placeholder par
            //la vraie valeur
            ->setParameter('idUser', $idUser)
            //on récupère le résultat
            ->getQuery();
        $profil = $query->getResult();
        return $profil;
    }
    public function delete(){

    }
}
