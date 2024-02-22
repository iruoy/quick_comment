<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Comment;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

class CommentController extends AbstractController
{
    #[Route('/api/comments', methods: ['GET', 'HEAD'])]
    public function index(EntityManagerInterface $entityManager, #[MapQueryParameter] string $postUrl): JsonResponse
    {
        $comments = $entityManager->getRepository(Comment::class)->findByPostUrl($postUrl);

        return $this->json($comments);
    }

    #[Route('/api/comments', methods: ['POST'])]
    public function create(EntityManagerInterface $entityManager, #[MapRequestPayload] Comment $comment): JsonResponse
    {
        $entityManager->persist($comment);
        $entityManager->flush();

        return $this->json($comment);
    }
}
