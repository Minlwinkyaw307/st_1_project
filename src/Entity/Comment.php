<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CommentRepository")
 */
class Comment
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $comment;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     */
    private $commented_by;

    /**
     * @ORM\Column(type="datetime")
     */
    private $commented_at;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Food")
     */
    private $product;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(string $comment): self
    {
        $this->comment = $comment;

        return $this;
    }

    public function getCommentedBy(): ?User
    {
        return $this->commented_by;
    }

    public function setCommentedBy(?User $commented_by): self
    {
        $this->commented_by = $commented_by;

        return $this;
    }

    public function getCommentedAt(): ?\DateTimeInterface
    {
        return $this->commented_at;
    }

    public function setCommentedAt(\DateTimeInterface $commented_at): self
    {
        $this->commented_at = $commented_at;

        return $this;
    }

    public function getProduct(): ?Food
    {
        return $this->product;
    }

    public function setProduct(?Food $product): self
    {
        $this->product = $product;

        return $this;
    }
}
