<?php

namespace App\Repository;

use App\Data\SearchData;
use App\Entity\Todo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Todo>
 *
 * @method Todo|null find($id, $lockMode = null, $lockVersion = null)
 * @method Todo|null findOneBy(array $criteria, array $orderBy = null)
 * @method Todo[]    findAll()
 * @method Todo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TodoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Todo::class);
    }


    public function findSearch(SearchData $data)
    {
        $query = $this->createQueryBuilder('t');
        if (!empty($data->q)) {
            $query = $query->andWhere("t.title LIKE  :q")
                ->setParameter('q', "%{$data->q}%");
        }
        if (!empty($data->statut)) {
            $query = $query->andWhere('t.statut=true');
        } else {
            $query = $query->andWhere('t.statut=false');
        }
        if (!empty($data->network)) {
            $query = $query->andWhere('t.network IN (:network)')
                ->setParameter('network', $data->network);
        }
        return $query->getQuery()->getResult();
    }

    //    /**
    //     * @return Todo[] Returns an array of Todo objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('t.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Todo
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
