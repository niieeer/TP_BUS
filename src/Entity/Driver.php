<?php

namespace App\Entity;

use App\Repository\DriverRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;

#[ORM\Entity(repositoryClass: DriverRepository::class)]
#[ApiResource(normalizationContext: ['groups' => ['read_driver']], denormalizationContext: ['groups' => ['write_driver']])]
class Driver extends User
{
    #[ORM\Column(type: 'integer')]
    private $license_number;

    #[ORM\OneToOne(inversedBy: 'id_driver', targetEntity: Bus::class, cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private $bus;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLicenseNumber(): ?int
    {
        return $this->license_number;
    }

    public function setLicenseNumber(int $license_number): self
    {
        $this->license_number = $license_number;

        return $this;
    }

    public function getBus(): ?Bus
    {
        return $this->bus;
    }

    public function setBus(Bus $bus): self
    {
        $this->bus = $bus;

        return $this;
    }
}


