<?php

namespace App\Entity;

use App\Entity\Image;
use App\Entity\CarOptions;
use App\Repository\AnnonceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AnnonceRepository::class)]
class Annonce
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    private ?string $carname = null;

    #[ORM\Column]
    private ?int $kilometrage = null;

    #[ORM\Column(length: 255)]
    private ?string $engine = null;

    #[ORM\Column(length: 255)]
    private ?string $gearbox = null;

    #[ORM\Column(length: 255)]
    private ?string $fuel = null;

    #[ORM\Column(length: 255)]
    private ?string $provenance = null;

    #[ORM\Column(length: 255)]
    private ?string $year = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $registrationDate = null;

    #[ORM\Column(length: 255)]
    private ?string $technicalControl = null;

    #[ORM\Column]
    private ?bool $firstHand = null;

    #[ORM\Column(length: 255)]
    private ?string $color = null;

    #[ORM\Column(length: 255)]
    private ?string $doors = null;

    #[ORM\Column]
    private ?int $seats = null;

    #[ORM\Column]
    private ?int $fiscalPower = null;

    #[ORM\Column]
    private ?int $horsePower = null;

    #[ORM\Column(length: 255)]
    private ?string $brand = null;

    #[ORM\Column]
    private ?float $price = null;

    #[ORM\Column]
    private ?float $fuelConsumption = null;

    #[ORM\OneToMany(mappedBy: 'annonce', targetEntity: Image::class, cascade: ['persist', 'remove'])]
    private Collection $images;

    #[ORM\ManyToMany(targetEntity: CarOptions::class, mappedBy: 'annonces')]
    private Collection $carOptions;

    public function __construct()
    {
        $this->images = new ArrayCollection();
        $this->carOptions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getCarname(): ?string
    {
        return $this->carname;
    }

    public function setCarname(string $carname): static
    {
        $this->carname = $carname;

        return $this;
    }

    public function getKilometrage(): ?int
    {
        return $this->kilometrage;
    }

    public function setKilometrage(int $kilometrage): static
    {
        $this->kilometrage = $kilometrage;

        return $this;
    }

    public function getEngine(): ?string
    {
        return $this->engine;
    }

    public function setEngine(string $engine): static
    {
        $this->engine = $engine;

        return $this;
    }

    public function getGearbox(): ?string
    {
        return $this->gearbox;
    }

    public function setGearbox(string $gearbox): static
    {
        $this->gearbox = $gearbox;

        return $this;
    }

    public function getFuel(): ?string
    {
        return $this->fuel;
    }

    public function setFuel(string $fuel): static
    {
        $this->fuel = $fuel;

        return $this;
    }

    public function getProvenance(): ?string
    {
        return $this->provenance;
    }

    public function setProvenance(string $provenance): static
    {
        $this->provenance = $provenance;

        return $this;
    }

    public function getYear(): ?string
    {
        return $this->year;
    }

    public function setYear(string $year): static
    {
        $this->year = $year;

        return $this;
    }

    public function getRegistrationDate(): ?\DateTimeInterface
    {
        return $this->registrationDate;
    }

    public function setRegistrationDate(\DateTimeInterface $registrationDate): static
    {
        $this->registrationDate = $registrationDate;

        return $this;
    }

    public function getTechnicalControl(): ?string
    {
        return $this->technicalControl;
    }

    public function setTechnicalControl(string $technicalControl): static
    {
        $this->technicalControl = $technicalControl;

        return $this;
    }

    public function isFirstHand(): ?bool
    {
        return $this->firstHand;
    }

    public function setFirstHand(bool $firstHand): static
    {
        $this->firstHand = $firstHand;

        return $this;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(string $color): static
    {
        $this->color = $color;

        return $this;
    }

    public function getDoors(): ?string
    {
        return $this->doors;
    }

    public function setDoors(string $doors): static
    {
        $this->doors = $doors;

        return $this;
    }

    public function getSeats(): ?int
    {
        return $this->seats;
    }

    public function setSeats(int $seats): static
    {
        $this->seats = $seats;

        return $this;
    }

    public function getFiscalPower(): ?int
    {
        return $this->fiscalPower;
    }

    public function setFiscalPower(int $fiscalPower): static
    {
        $this->fiscalPower = $fiscalPower;

        return $this;
    }

    public function getHorsePower(): ?int
    {
        return $this->horsePower;
    }

    public function setHorsePower(int $horsePower): static
    {
        $this->horsePower = $horsePower;

        return $this;
    }

    public function getBrand(): ?string
    {
        return $this->brand;
    }

    public function setBrand(string $brand): static
    {
        $this->brand = $brand;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getFuelConsumption(): ?float
    {
        return $this->fuelConsumption;
    }

    public function setFuelConsumption(float $fuelConsumption): static
    {
        $this->fuelConsumption = $fuelConsumption;

        return $this;
    }

    /**
     * @return Collection<int, Image>
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(Image $image): static
    {
        if (!$this->images->contains($image)) {
            $this->images->add($image);
            $image->setAnnonce($this);
        }

        return $this;
    }

    public function removeImage(Image $image): static
    {
        if ($this->images->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getAnnonce() === $this) {
                $image->setAnnonce(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, CarOptions>
     */
    public function getCarOptions(): Collection
    {
        return $this->carOptions;
    }

    public function addCarOption(CarOptions $carOption): static
    {
        if (!$this->carOptions->contains($carOption)) {
            $this->carOptions->add($carOption);
            $carOption->addAnnonce($this);
        }

        return $this;
    }

    public function removeCarOption(CarOptions $carOption): static
    {
        if ($this->carOptions->removeElement($carOption)) {
            $carOption->removeAnnonce($this);
        }

        return $this;
    }
}
