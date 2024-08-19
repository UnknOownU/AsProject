<?php

namespace App\Entity;

use App\Repository\TechnicalControlAppointmentRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: TechnicalControlAppointmentRepository::class)]
class TechnicalControlAppointment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: 'uuid', unique: true)]
    private ?Uuid $uuid = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(length: 255)]
    private ?string $firstname = null;
    
    #[ORM\Column(length: 255)]
    private ?string $lastname = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $phone = null;

    #[ORM\Column(length: 255)]
    private ?string $carBrand = null;

    #[ORM\Column(length: 255)]
    private ?string $carModel = null;

    #[ORM\Column(length: 255)]
    private ?string $licensePlate = null;

    #[ORM\Column(length: 255)]
    private ?string $fuelType = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $comments = null;

    #[ORM\Column(length: 255)]
    private ?string $controlType = null;
    
    #[ORM\Column(length: 255)]
    private ?string $carType = null;


    public function __construct()
    {
        // Générer un UUID lors de la création de l'objet
        $this->uuid = Uuid::v4();
        // Initialiser la date de création à maintenant
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUuid(): ?Uuid
    {
        return $this->uuid;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }
    
    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getCarBrand(): ?string
    {
        return $this->carBrand;
    }

    public function setCarBrand(string $carBrand): self
    {
        $this->carBrand = $carBrand;

        return $this;
    }

    public function getCarModel(): ?string
    {
        return $this->carModel;
    }

    public function setCarModel(string $carModel): self
    {
        $this->carModel = $carModel;

        return $this;
    }

    public function getLicensePlate(): ?string
    {
        return $this->licensePlate;
    }

    public function setLicensePlate(string $licensePlate): self
    {
        $this->licensePlate = $licensePlate;

        return $this;
    }

    public function getFuelType(): ?string
    {
        return $this->fuelType;
    }

    public function setFuelType(string $fuelType): self
    {
        $this->fuelType = $fuelType;

        return $this;
    }

    public function getComments(): ?string
    {
        return $this->comments;
    }

    public function setComments(?string $comments): self
    {
        $this->comments = $comments;

        return $this;
    }

    public function getControlType(): ?string
    {
        return $this->controlType;
    }

    public function setControlType(string $controlType): self
    {
        $this->controlType = $controlType;

        return $this;
    }
    public function getCarType(): ?string
    {
        return $this->carType;
    }

    public function setCarType(string $carType): self
    {
        $this->carType = $carType;

        return $this;
    }
}
