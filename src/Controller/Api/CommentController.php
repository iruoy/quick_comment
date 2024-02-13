<?php

namespace App\Controller\Api;

use App\Entity\Comment;
use App\Entity\Post;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

class CommentController extends AbstractController
{
    #[Route('/api/comments', methods: ['GET', 'HEAD'])]
    public function index(EntityManagerInterface $entityManager, #[MapQueryParameter] string $url): JsonResponse
    {
        $comments = $entityManager->getRepository(Comment::class)->findByPostUrl($url);

        $data = [];
        foreach ($comments as $comment) {
            $data[] = [
                'name' => $comment->getName(),
                'email' => $comment->getEmail(),
                'comment' => $comment->getComment(),
                'createdAt' => $comment->getCreatedAt(),
            ];
        }

        return $this->json($data);
    }

    #[Route('/api/comments', methods: ['POST'])]
    public function create(
        EntityManagerInterface       $entityManager,
        #[MapQueryParameter] string  $url,
        #[MapRequestPayload] Comment $comment
    ): JsonResponse {
        $post = $this->getPost($entityManager, $url);
        $post->addComment($comment);

        $entityManager->persist($comment);
        $entityManager->flush();

        return $this->json(['success' => true]);
    }

    private function getPost(EntityManagerInterface $entityManager, string $url): ?Post
    {
        $post = $entityManager->getRepository(Post::class)->findOneByUrl($url);
        if (!$post) {
            $post = new Post();
            $post->setUrl($url);
            $entityManager->persist($post);
        }

        return $post;
    }
}
