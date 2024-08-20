<?php
namespace App\Entity;

use App\Repository\BookingRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: BookingRepository::class)]
class Booking
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: 'uuid', unique: true)]
    private ?Uuid $uuid = null;

    #[ORM\Column(type: 'datetime_immutable')]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(length: 255)]
    private ?string $status = null;

    #[ORM\ManyToOne(targetEntity: InspectionForm::class, inversedBy: 'bookings', cascade: ['persist'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?InspectionForm $inspectionForm = null;
    

    #[ORM\ManyToOne(targetEntity: Timeslot::class, inversedBy: 'bookings')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Timeslot $timeslot = null;

    public function __construct()
    {
         $this->uuid = Uuid::v4();
        $this->createdAt = new \DateTimeImmutable();
        $this->status = 'Créé';  // Initialisez le statut par défaut ici
    }

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getInspectionForm(): ?InspectionForm
    {
        return $this->inspectionForm;
    }

    public function setInspectionForm(?InspectionForm $inspectionForm): self
    {
        $this->inspectionForm = $inspectionForm;

        return $this;
    }

    public function getTimeslot(): ?Timeslot
    {
        return $this->timeslot;
    }

    public function setTimeslot(?Timeslot $timeslot): self
    {
        $this->timeslot = $timeslot;

        return $this;
    }
}
