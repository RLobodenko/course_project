<?php

namespace App\Entity;

use App\Repository\CartRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CartRepository::class)]
class Cart
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $summa = null;

    #[ORM\Column(length: 255)]
    private ?string $products = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSumma(): ?int
    {
        return $this->summa;
    }

    public function setSumma(int $summa): static
    {
        $this->summa = $summa;

        return $this;
    }

    public function getProducts(): ?string
    {
        return $this->products;
    }

    public function setProducts(string $products): static
    {
        $this->products = $products;

        return $this;
    }
}
