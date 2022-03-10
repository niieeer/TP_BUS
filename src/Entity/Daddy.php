<?php

namespace App\Entity;

use App\Repository\DaddyRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DaddyRepository::class)]
#[ApiResource(normalizationContext: ['groups' => ['read_daddy']], denormalizationContext: ['groups' => ['write_daddy']])]
class Daddy extends User
{
    #[ORM\OneToMany(mappedBy: 'id_daddy', targetEntity: Student::class)]
    private $students;

    #[ORM\Column(type: 'string', length: 100)]
    private $phone_number;

    public function __construct()
    {
        $this->students = new ArrayCollection();
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
            $student->setIdDaddy($this);
        }

        return $this;
    }

    public function removeStudent(Student $student): self
    {
        if ($this->students->removeElement($student)) {
            // set the owning side to null (unless already changed)
            if ($student->getIdDaddy() === $this) {
                $student->setIdDaddy(null);
            }
        }

        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phone_number;
    }

    public function setPhoneNumber(string $phone_number): self
    {
        $this->phone_number = $phone_number;

        return $this;
    }
}
