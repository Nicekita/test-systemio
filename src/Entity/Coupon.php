<?php

namespace App\Entity;

use App\Repository\CouponRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CouponRepository::class)]
class Coupon
{
    #[ORM\Id]
    #[ORM\Column(length: 10)]
    private ?string $code = null;


    #[ORM\Column]
    private ?int $discount = null;

    #[ORM\Column]
    private ?bool $is_fixed = null;

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

    public function getDiscount(): ?int
    {
        return $this->discount;
    }

    public function setDiscount(int $discount): static
    {
        $this->discount = $discount;

        return $this;
    }

    public function isFixed(): ?bool
    {
        return $this->is_fixed;
    }

    public function setFixed(bool $is_fixed): static
    {
        $this->is_fixed = $is_fixed;

        return $this;
    }
}
