<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\ObjectifRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ObjectifRepository::class)]
#[ApiResource]
class Objectif
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $month = null;

    #[ORM\Column]
    private ?int $year = null;

    #[ORM\Column(length: 255)]
    private ?string $service = null;

    #[ORM\Column]
    private ?int $objectif = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMonth(): ?int
    {
        return $this->month;
    }

    public function setMonth(int $month): static
    {
        $this->month = $month;

        return $this;
    }

    public function getYear(): ?int
    {
        return $this->year;
    }

    public function setYear(int $year): static
    {
        $this->year = $year;

        return $this;
    }

    public function getService(): ?string
    {
        return $this->service;
    }

    public function setService(string $service): static
    {
        $this->service = $service;

        return $this;
    }

    public function getObjectif(): ?int
    {
        return $this->objectif;
    }

    public function setObjectif(int $objectif): static
    {
        $this->objectif = $objectif;

        return $this;
    }
}

