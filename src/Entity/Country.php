<?php

namespace App\Entity;

use App\Repository\CountryRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CountryRepository::class)]
class Country
{

    #[ORM\Column(length: 2)]
    #[ORM\Id]
    private ?string $code = null;

    #[ORM\Column]
    private ?int $symbols = null;

    #[ORM\Column]
    private ?int $numbers = null;

    #[ORM\Column]
    private ?int $tax = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): static
    {
        $this->code = $code;

        return $this;
    }

    public function getSymbols(): ?int
    {
        return $this->symbols;
    }

    public function setSymbols(int $symbols): static
    {
        $this->symbols = $symbols;

        return $this;
    }

    public function getNumbers(): ?int
    {
        return $this->numbers;
    }

    public function setNumbers(int $numbers): static
    {
        $this->numbers = $numbers;

        return $this;
    }

    public function getTax(): ?int
    {
        return $this->tax;
    }

    public function setTax(int $tax): static
    {
        $this->tax = $tax;

        return $this;
    }
}
