<?php

namespace App\Entity;

use App\Repository\StationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StationRepository::class)]
class Station
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 5)]
    private ?string $stationCode = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?float $longitude = null;

    #[ORM\Column]
    private ?float $latitude = null;

    #[ORM\Column(nullable: true)]
    private ?int $numDockAvailable = null;

    #[ORM\Column(nullable: true)]
    private ?int $numBikesAvailable = null;

    #[ORM\Column(nullable: true)]
    private ?int $nbMechanicalBike = null;

    #[ORM\Column(nullable: true)]
    private ?int $nbEBikes = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $dueDate = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStationCode(): ?string
    {
        return $this->stationCode;
    }

    public function setStationCode(string $stationCode): static
    {
        $this->stationCode = $stationCode;

        return $this;
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

    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    public function setLongitude(float $longitude): static
    {
        $this->longitude = $longitude;

        return $this;
    }

    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    public function setLatitude(float $latitude): static
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getNumDockAvailable(): ?int
    {
        return $this->numDockAvailable;
    }

    public function setNumDockAvailable(?int $numDockAvailable): static
    {
        $this->numDockAvailable = $numDockAvailable;

        return $this;
    }

    public function getNumBikesAvailable(): ?int
    {
        return $this->numBikesAvailable;
    }

    public function setNumBikesAvailable(?int $numBikesAvailable): static
    {
        $this->numBikesAvailable = $numBikesAvailable;

        return $this;
    }

    public function getNbMechanicalBike(): ?int
    {
        return $this->nbMechanicalBike;
    }

    public function setNbMechanicalBike(?int $nbMechanicalBike): static
    {
        $this->nbMechanicalBike = $nbMechanicalBike;

        return $this;
    }

    public function getNbEBikes(): ?int
    {
        return $this->nbEBikes;
    }

    public function setNbEBikes(?int $nbEBikes): static
    {
        $this->nbEBikes = $nbEBikes;

        return $this;
    }

    public function getDueDate(): ?string
    {
        return $this->dueDate;
    }

    public function setDueDate(?string $dueDate): static
    {
        $this->dueDate = $dueDate;
 
        return $this;
    }
}
