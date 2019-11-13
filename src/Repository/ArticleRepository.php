<?php

namespace App\Repository;

use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\QueryBuilder;

/**
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[]    findAll()
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }

    /**
     * @return Article[]
     */
    public function findAllPublishedOrderedByNewest()
    {
        return $this->addispublishedQueryBuilder()
            ->orderBy('article.pulishedAt', 'DESC')
            ->getQuery()
            ->getResult();
    }

    private function addispublishedQueryBuilder(QueryBuilder $queryBuilder = null)
    {
        return $this->getOrCreateQueryBuilder($queryBuilder)->andWhere('article.pulishedAt IS NOT NULL');
    }

    private function getOrCreateQueryBuilder(QueryBuilder $queryBuilder = null)
    {
        return $queryBuilder ?: $this->createQueryBuilder('article');
    }
}
