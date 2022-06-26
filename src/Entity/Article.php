<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity]
class Article
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups('read')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups('read')]
    private $shortDescription;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2)]
    #[Groups('read')]
    private $price;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2)]
    private $pricePerUnit;

    #[ORM\Column(type: 'string', length: 50)]
    #[Groups('read')]
    private $unit;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups('read')]
    private $image;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getShortDescription(): ?string
    {
        return $this->shortDescription;
    }

    public function setShortDescription(string $shortDescription): self
    {
        $this->shortDescription = $shortDescription;

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

    public function getPricePerUnit(): ?float
    {
        return $this->pricePerUnit;
    }

    public function setPricePerUnit(float $pricePerUnit): self
    {
        $this->pricePerUnit = $pricePerUnit;

        return $this;
    }

    public function getUnit(): ?string
    {
        return $this->unit;
    }

    public function setUnit(string $unit): self
    {
        $this->unit = $unit;

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

    #[Groups('read')]
    public function getPricePerUnitText(): ?string
    {
        return sprintf('(%s €/%s)', $this->pricePerUnit, $this->unit);
    }
}
