<?php

declare(strict_types=1);

namespace App\Components;

use App\Entity\Comment;
use App\Repository\CommentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveListener;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent]
class Comments extends AbstractController
{
    use DefaultActionTrait;

    #[LiveProp(writable: true, url: true)]
    public string $url = '';

    public function __construct(
        private readonly CommentRepository $commentRepository
    ) {
    }

    /**
     * @return Comment[]
     */
    #[LiveListener('commentAdded')]
    public function getComments(): array
    {
        return $this->commentRepository->findByPostUrl($this->url);
    }
}
