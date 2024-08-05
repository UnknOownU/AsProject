<?php

// src/Entity/Annonce.php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AnnonceRepository")
 */
class Annonce
{
    /**
     * @ORM\Id
     *
     * @ORM\GeneratedValue
     *
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Assert\NotBlank
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     *
     * @Assert\NotBlank
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Assert\NotBlank
     */
    private $carName;

    /**
     * @ORM\Column(type="integer")
     *
     * @Assert\NotBlank
     *
     * @Assert\Type(type="integer")
     */
    private $kilometrage;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Assert\NotBlank
     */
    private $engine;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Assert\NotBlank
     */
    private $gearbox;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Assert\NotBlank
     */
    private $fuel;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Assert\NotBlank
     */
    private $provenance;

    /**
     * @ORM\Column(type="integer")
     *
     * @Assert\NotBlank
     *
     * @Assert\Type(type="integer")
     */
    private $year;

    /**
     * @ORM\Column(type="date")
     *
     * @Assert\NotBlank
     */
    private $registrationDate;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Assert\NotBlank
     */
    private $technicalControl;

    /**
     * @ORM\Column(type="boolean")
     *
     * @Assert\NotBlank
     */
    private $firstHand;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Assert\NotBlank
     */
    private $color;

    /**
     * @ORM\Column(type="integer")
     *
     * @Assert\NotBlank
     *
     * @Assert\Type(type="integer")
     */
    private $doors;

    /**
     * @ORM\Column(type="integer")
     *
     * @Assert\NotBlank
     *
     * @Assert\Type(type="integer")
     */
    private $seats;

    /**
     * @ORM\Column(type="decimal", scale=2)
     *
     * @Assert\NotBlank
     */
    private $length;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Assert\NotBlank
     */
    private $trunkVolume;

    /**
     * @ORM\Column(type="integer")
     *
     * @Assert\NotBlank
     *
     * @Assert\Type(type="integer")
     */
    private $fiscalPower;

    /**
     * @ORM\Column(type="integer")
     *
     * @Assert\NotBlank
     *
     * @Assert\Type(type="integer")
     */
    private $horsePower;

    /**
     * @ORM\Column(type="decimal", scale=2)
     *
     * @Assert\NotBlank
     */
    private $fuelConsumption;

    /**
     * @ORM\Column(type="integer")
     *
     * @Assert\NotBlank
     *
     * @Assert\Type(type="integer")
     */
    private $co2Emission;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Assert\NotBlank
     */
    private $euroNorm;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Assert\NotBlank
     */
    private $critAir;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
    }

    // Getters et Setters

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getCarName(): ?string
    {
        return $this->carName;
    }

    public function setCarName(string $carName): self
    {
        $this->carName = $carName;

        return $this;
    }

    public function getKilometrage(): ?int
    {
        return $this->kilometrage;
    }

    public function setKilometrage(int $kilometrage): self
    {
        $this->kilometrage = $kilometrage;

        return $this;
    }

    public function getEngine(): ?string
    {
        return $this->engine;
    }

    public function setEngine(string $engine): self
    {
        $this->engine = $engine;

        return $this;
    }

    public function getGearbox(): ?string
    {
        return $this->gearbox;
    }

    public function setGearbox(string $gearbox): self
    {
        $this->gearbox = $gearbox;

        return $this;
    }

    public function getFuel(): ?string
    {
        return $this->fuel;
    }

    public function setFuel(string $fuel): self
    {
        $this->fuel = $fuel;

        return $this;
    }

    public function getProvenance(): ?string
    {
        return $this->provenance;
    }

    public function setProvenance(string $provenance): self
    {
        $this->provenance = $provenance;

        return $this;
    }

    public function getYear(): ?int
    {
        return $this->year;
    }

    public function setYear(int $year): self
    {
        $this->year = $year;

        return $this;
    }

    public function getRegistrationDate(): ?\DateTimeInterface
    {
        return $this->registrationDate;
    }

    public function setRegistrationDate(\DateTimeInterface $registrationDate): self
    {
        $this->registrationDate = $registrationDate;

        return $this;
    }

    public function getTechnicalControl(): ?string
    {
        return $this->technicalControl;
    }

    public function setTechnicalControl(string $technicalControl): self
    {
        $this->technicalControl = $technicalControl;

        return $this;
    }

    public function getFirstHand(): ?bool
    {
        return $this->firstHand;
    }

    public function setFirstHand(bool $firstHand): self
    {
        $this->firstHand = $firstHand;

        return $this;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(string $color): self
    {
        $this->color = $color;

        return $this;
    }

    public function getDoors(): ?int
    {
        return $this->doors;
    }

    public function setDoors(int $doors): self
    {
        $this->doors = $doors;

        return $this;
    }

    public function getSeats(): ?int
    {
        return $this->seats;
    }

    public function setSeats(int $seats): self
    {
        $this->seats = $seats;

        return $this;
    }

    public function getLength(): ?string
    {
        return $this->length;
    }

    public function setLength(string $length): self
    {
        $this->length = $length;

        return $this;
    }

    public function getTrunkVolume(): ?string
    {
        return $this->trunkVolume;
    }

    public function setTrunkVolume(string $trunkVolume): self
    {
        $this->trunkVolume = $trunkVolume;

        return $this;
    }

    public function getFiscalPower(): ?int
    {
        return $this->fiscalPower;
    }

    public function setFiscalPower(int $fiscalPower): self
    {
        $this->fiscalPower = $fiscalPower;

        return $this;
    }

    public function getHorsePower(): ?int
    {
        return $this->horsePower;
    }

    public function setHorsePower(int $horsePower): self
    {
        $this->horsePower = $horsePower;

        return $this;
    }

    public function getFuelConsumption(): ?string
    {
        return $this->fuelConsumption;
    }

    public function setFuelConsumption(string $fuelConsumption): self
    {
        $this->fuelConsumption = $fuelConsumption;

        return $this;
    }

    public function getCo2Emission(): ?int
    {
        return $this->co2Emission;
    }

    public function setCo2Emission(int $co2Emission): self
    {
        $this->co2Emission = $co2Emission;

        return $this;
    }

    public function getEuroNorm(): ?string
    {
        return $this->euroNorm;
    }

    public function setEuroNorm(string $euroNorm): self
    {
        $this->euroNorm = $euroNorm;

        return $this;
    }

    public function getCritAir(): ?string
    {
        return $this->critAir;
    }

    public function setCritAir(string $critAir): self
    {
        $this->critAir = $critAir;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
