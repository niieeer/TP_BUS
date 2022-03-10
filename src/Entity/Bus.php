<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\BusRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: BusRepository::class)]
#[ApiResource(normalizationContext: ['groups' => ['read_bus']], denormalizationContext: ['groups' => ['write_bus']])]
class Bus
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['read_bus', "write_bus"])]
    private $id;

    #[ORM\Column(type: 'integer')]
    #[Groups(['read_bus', "write_bus"])]
    private $registration_number;

    #[ORM\Column(type: 'date')]
    #[Groups(['read_bus', "write_bus"])]
    private $date_start_up;

    #[ORM\Column(type: 'integer')]
    #[Groups(['read_bus', "write_bus"])]
    private $number_years_service;

    #[ORM\Column(type: 'integer')]
    #[Groups(['read_bus', "write_bus"])]
    private $total_weight;

    #[ORM\OneToOne(mappedBy: 'bus', targetEntity: Driver::class, cascade: ['persist', 'remove'])]
    #[Groups(['read_bus', "write_bus"])]
    private $id_driver;

    #[ORM\OneToMany(mappedBy: 'id_bus', targetEntity: Student::class)]
    #[Groups(['read_bus', "write_bus"])]
    private $students;

    public function __construct()
    {
        $this->students = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRegistrationNumber(): ?int
    {
        return $this->registration_number;
    }

    public function setRegistrationNumber(int $registration_number): self
    {
        $this->registration_number = $registration_number;

        return $this;
    }

    public function getDateStartUp(): ?\DateTimeInterface
    {
        return $this->date_start_up;
    }

    public function setDateStartUp(\DateTimeInterface $date_start_up): self
    {
        $this->date_start_up = $date_start_up;

        return $this;
    }

    public function getNumberYearsService(): ?int
    {
        return $this->number_years_service;
    }

    public function setNumberYearsService(int $number_years_service): self
    {
        $this->number_years_service = $number_years_service;

        return $this;
    }

    public function getTotalWeight(): ?int
    {
        return $this->total_weight;
    }

    public function setTotalWeight(int $total_weight): self
    {
        $this->total_weight = $total_weight;

        return $this;
    }

    public function getIdDriver(): ?Driver
    {
        return $this->id_driver;
    }

    public function setIdDriver(Driver $id_driver): self
    {
        // set the owning side of the relation if necessary
        if ($id_driver->getBus() !== $this) {
            $id_driver->setBus($this);
        }

        $this->id_driver = $id_driver;

        return $this;
    }

    /**
     * @return Collection<int, Student>
     */
    public function getStudents(): Collection
    {
        return $this->students;
    }

    public function addStudent(Student $student): self
    {
        if (!$this->students->contains($student)) {
            $this->students[] = $student;
            $student->setIdBus($this);
        }

        return $this;
    }

    public function removeStudent(Student $student): self
    {
        if ($this->students->removeElement($student)) {
            // set the owning side to null (unless already changed)
            if ($student->getIdBus() === $this) {
                $student->setIdBus(null);
            }
        }

        return $this;
    }
}
