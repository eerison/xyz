<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Common\Filter\DateFilterInterface;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\DateFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\NumericFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity]
#[ApiResource(
    collectionOperations: ['get'],
    itemOperations: ['get'],
    normalizationContext: ['groups' => ['read']],
)]
#[ApiFilter(NumericFilter::class, properties: ['articles.price' => 'exact'])]
#[ApiFilter(
    OrderFilter::class
    , properties: ['articles.price' => 'ASC', 'articles.pricePerUnit'=>'ASC']
    , arguments: ['orderParameterName' => 'order']
)]
#[ApiFilter(
    DateFilter::class
    , properties: ['articles' => DateFilterInterface::EXCLUDE_NULL]
)]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups('read')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups('read')]
    private $name;

    #[ORM\ManyToMany(targetEntity: Article::class)]
    #[ORM\JoinTable(name: "products_articles")]
    #[ORM\JoinColumn(name: "product_id", referencedColumnName: "id")]
    #[ORM\InverseJoinColumn(name: "article_id", referencedColumnName: "id")]
    #[Groups('read')]
    private $articles;

    #[ORM\Column(type: 'text', nullable: true)]
    #[Groups('read')]
    private $descriptionText;

    #[ORM\ManyToOne(targetEntity: Brand::class, inversedBy: 'products')]
    private $brand;

    public function __construct()
    {
        $this->articles = new ArrayCollection();
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

    /**
     * @return Collection<int, Article>
     */
    public function getArticles(): Collection
    {
        return $this->articles;
    }

    public function setArticles(Collection $articles): static
    {
        foreach ($articles as $article) {
            $this->addArticle($article);
        }

        return $this;
    }

    public function addArticle(Article $article): self
    {
        if (!$this->articles->contains($article)) {
            $this->articles[] = $article;
        }

        return $this;
    }

    public function removeArticle(Article $article): self
    {
        $this->articles->removeElement($article);
        return $this;
    }

    public function getDescriptionText(): ?string
    {
        return $this->descriptionText;
    }

    public function setDescriptionText(?string $descriptionText): self
    {
        $this->descriptionText = $descriptionText;

        return $this;
    }

    public function getBrand(): ?Brand
    {
        return $this->brand;
    }

    public function setBrand(?Brand $brand): self
    {
        $this->brand = $brand;

        return $this;
    }

    #[Groups('read')]
    public function getBrandName(): string
    {
        return $this->getBrand()->getName();
    }
}
