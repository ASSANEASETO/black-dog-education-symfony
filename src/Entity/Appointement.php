<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\AppointementRepository;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: AppointementRepository::class)]
class Appointement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank]
    private string $name;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank]
    private string $prestations;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank]
    private string $breed;

    #[ORM\Column(type: 'integer')]
    #[Assert\NotBlank]
    private int $dogNumber;

    #[ORM\Column(type: 'integer')]
    #[Assert\NotBlank]
    private int $puppyNumber;

    #[ORM\Column(type: 'integer')]
    #[Assert\NotBlank]
    private int $phoneNumber;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\NotBlank]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    #[Assert\NotBlank]
    private ?\DateTimeInterface $time = null;

    #[ORM\Column(nullable: true)]
    private ?int $age = null;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank]
    private string $email;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getprestations(): ?string
    {
        return $this->prestations;
    }

    public function setprestations(string $prestations): static
    {
        $this->prestations = $prestations;

        return $this;
    }

    public function getbreed(): ?string
    {
        return $this->breed;
    }

    public function setbreed(string $breed): static
    {
        $this->breed = $breed;

        return $this;
    }

    public function getDogNumber(): ?int
    {
        return $this->dogNumber;
    }

    public function setDogNumber(int $dogNumber): static
    {
        $this->dogNumber = $dogNumber;

        return $this;
    }

    public function getPuppyNumber(): ?int
    {
        return $this->puppyNumber;
    }

    public function setPuppyNumber(int $puppyNumber): static
    {
        $this->puppyNumber = $puppyNumber;

        return $this;
    }

    public function getPhoneNumber(): ?int
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(int $phoneNumber): static
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getTime(): ?\DateTimeInterface
    {
        return $this->time;
    }

    public function setTime(\DateTimeInterface $time): static
    {
        $this->time = $time;

        return $this;
    }

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function setAge(?int $age): static
    {
        $this->age = $age;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): static
    {
        $this->email = $email;

        return $this;
    }
}
