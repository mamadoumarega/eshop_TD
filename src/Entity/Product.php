<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource(
 *     normalizationContext={"groups"={"product:read"}},
 *     denormalizationContext={"groups"={"product:write"}},
 *     attributes={"items_per_page"=10}
 * )
 * @ApiFilter(SearchFilter::class, properties={"categories": "exact", "user": "exact"})
 * @ORM\Entity(repositoryClass=ProductRepository::class)
 */
class Product
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\NotBlank(message="Ce champ ne peut pas être vide. ")
     * @Assert\Length(max="150", maxMessage="La taille autorisée a été dépasser. ")
     * @ORM\Column(type="string", length=150)
     * @Groups({"product:read", "product:write"})
     */
    private $name;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups({"product:read", "product:write"})
     */
    private $description;

    /**
     * @Assert\NotBlank(message="Ce champ ne peut pas être vide. ")
     * @ORM\Column(type="float")
     * @Groups({"product:read", "product:write"})
     */
    private $price;

    /**
     * @Assert\Length(max="255", maxMessage="Vous avez dépassé la taille autoriisée. ")
     * @Assert\NotBlank(message="Ce champ ne peut pas être vide. ")
     * @ORM\Column(type="string", length=255)
     * @Groups({"product:read", "product:write"})
     */
    private $image;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"product:read", "product:write"})
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"product:read", "product:write"})
     */
    private $updatedAt;

    /**
     * @ORM\ManyToMany(targetEntity=Category::class, inversedBy="products")
     * @Groups({"product:read"})
     */
    private $categories;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="products")
     * @Groups({"product:read"})
     */
    private $user;

    public function __construct()
    {
        $this->categories = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

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

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @return Collection|Category[]
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Category $category): self
    {
        if (!$this->categories->contains($category)) {
            $this->categories[] = $category;
        }

        return $this;
    }

    public function removeCategory(Category $category): self
    {
        $this->categories->removeElement($category);

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
