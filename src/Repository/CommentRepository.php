<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Comment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Comment>
 *
 * @method Comment|null find($id, $lockMode = null, $lockVersion = null)
 * @method Comment|null findOneBy(array $criteria, array $orderBy = null)
 * @method Comment[]    findAll()
 * @method Comment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $managerRegistry)
    {
        parent::__construct($managerRegistry, Comment::class);
    }

    /**
     * @return Comment[]
     */
    public function findByPostUrl(string $postUrl): array
    {
        /** @var Comment[] */
        return $this->createQueryBuilder('c')
            ->andWhere('c.postUrl = :postUrl')
            ->setParameter('postUrl', $postUrl)
            ->getQuery()
            ->getResult()
        ;
    }
}
