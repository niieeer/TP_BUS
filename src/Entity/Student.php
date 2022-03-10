<?php

namespace App\Entity;

use App\Repository\StudentRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;

#[ORM\Entity(repositoryClass: StudentRepository::class)]
#[ApiResource(normalizationContext: ['groups' => ['read_student']], denormalizationContext: ['groups' => ['write_student']])]
class Student extends User
{
    #[ORM\ManyToOne(targetEntity: Daddy::class, inversedBy: 'students')]
    private $id_daddy;

    #[ORM\ManyToOne(targetEntity: Bus::class, inversedBy: 'students')]
    private $id_bus;

    public function getIdDaddy(): ?Daddy
    {
        return $this->id_daddy;
    }

    public function setIdDaddy(?Daddy $id_daddy): self
    {
        $this->id_daddy = $id_daddy;

        return $this;
    }

    public function getIdBus(): ?Bus
    {
        return $this->id_bus;
    }

    public function setIdBus(?Bus $id_bus): self
    {
        $this->id_bus = $id_bus;

        return $this;
    }
}
