<?php

declare(strict_types=1);

namespace App\Components;

use App\Entity\Comment;
use App\Entity\Post;
use App\Form\CommentFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\ComponentToolsTrait;
use Symfony\UX\LiveComponent\ComponentWithFormTrait;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent]
class CommentForm extends AbstractController
{
    use ComponentToolsTrait;
    use ComponentWithFormTrait;
    use DefaultActionTrait;

    #[LiveProp(updateFromParent: true)]
    public string $url = '';

    protected function instantiateForm(): FormInterface
    {
        return $this->createForm(CommentFormType::class);
    }

    #[LiveAction]
    public function save(EntityManagerInterface $entityManager): void
    {
        $this->submitForm();

        /** @var Comment $comment */
        $comment = $this->getForm()->getData();

        $post = $this->getPost($entityManager);
        $post->addComment($comment);

        $entityManager->persist($comment);
        $entityManager->flush();

        $this->resetForm();

        $this->emit('commentAdded');
    }

    private function getPost(EntityManagerInterface $entityManager): Post
    {
        $post = $entityManager->getRepository(Post::class)->findOneByUrl($this->url);
        if (! $post instanceof Post) {
            $post = new Post();
            $post->setUrl($this->url);
            $entityManager->persist($post);
        }

        return $post;
    }
}
