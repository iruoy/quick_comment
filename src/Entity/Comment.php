<?php

namespace App\Entity;

use App\Repository\CommentRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CommentRepository::class)]
class Comment
{
    
    #[ORM\Column]
    private readonly \DateTimeImmutable $createdAt;

    public function __construct(
        #[ORM\Id]
        #[ORM\GeneratedValue]
        #[ORM\Column]
        private readonly int $id,
    
        #[Assert\NotBlank]
        #[Assert\Length(max: 255)]
        #[ORM\Column(length: 255)]
        private ?string $postUrl = null,
    
        #[Assert\NotBlank]
        #[Assert\Length(max: 255)]
        #[ORM\Column(length: 255)]
        private ?string $name = null,
    
        #[Assert\Length(max: 255)]
        #[ORM\Column(length: 255, nullable: true)]
        private ?string $email = null,
    
        #[Assert\NotBlank]
        #[ORM\Column(type: Types::TEXT)]
        private ?string $comment = null,
        ){
            
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPostUrl(): ?string
    {
        return $this->postUrl;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }


    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }
}
