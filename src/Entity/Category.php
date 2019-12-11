<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CategoryRepository")
 */
class Category
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

//    /**
//     * @ORM\ManyToOne(targetEntity="App\Entity\Category")
//     * @ORM\JoinColumn(onDelete="SET NULL")
//     * @ORM\Column(nullable=true)
//     */
//    private $parentid;

    /**
     * @ORM\Column(type="string", length=150, nullable=true)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=1000, nullable=true)
     */
    private $keywords;

    /**
     * @ORM\Column(type="string", length=500, nullable=true)
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Image")
     * @ORM\JoinColumn(onDelete="SET NULL")
     */
    private $image;

    /**
     * @ORM\Column(type="string", length=15, nullable=true)
     */
    private $status;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updated_at;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Category")
     */
    private $parentid;

    public function getId(): ?int
    {
        return $this->id;
    }

//    public function getParentid(): ?Category
//    {
//        if($this->parentid == "0")
//        {
//            $p = new Category();
//            $p->setName("Main Category");
//            return $p;
//        }
//        dump($this->parentid);
////        return $this->parentid;
//        $p = new Category();
//        $p->setName("Main Category");
//        return $p;
//    }

//    public function setParentid(?int $parentid): self
//    {
//        $this->parentid = $parentid;
//        return $this;
//    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getKeywords(): ?string
    {
        return $this->keywords;
    }

    public function setKeywords(?string $keywords): self
    {
        $this->keywords = $keywords;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getImage(): ?Image
    {
//        dump($this->image);
        return $this->image;
    }

    public function setImage(?Image $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(?\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(?\DateTimeInterface $updated_at): self
    {
        $this->updated_at = $updated_at;
        return $this;
    }

    public function getParentid(): ?self
    {
//        if(!$this->parentid)
//        {
//            $p = new Category();
//            $p->setName("Main Category");
//            return $p;
//        }
//        dump($this->parentid);
        return $this->parentid;
    }

    public function setParentid(?Category $parentid): self
    {
        $this->parentid = $parentid;

        return $this;
    }
}
