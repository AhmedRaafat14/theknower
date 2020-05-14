<?php

namespace App\Repository;

use App\Entity\Comment;
use App\Entity\Contribution;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Comment|null find($id, $lockMode = null, $lockVersion = null)
 * @method Comment|null findOneBy(array $criteria, array $orderBy = null)
 * @method Comment[]    findAll()
 * @method Comment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Comment::class);
    }

    public function save(Comment $comment): void
    {
        $this->getEntityManager()->persist($comment);
        $this->getEntityManager()->flush();
    }

    /**
     * @param $commentContent
     * @param $contributionId
     * @param $user
     * @return Comment
     */
    public function insertOne($content, $contributionId, $user): Comment
    {
        $comment = new Comment();

        $comment->setContent($content);
        $comment->setUser($user);
        $comment->setContribution($this->getEntityManager()->getRepository(Contribution::class)->find($contributionId));

        $this->save($comment);

        return $comment;
    }
}
