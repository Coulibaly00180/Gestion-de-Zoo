<?php

namespace App\Entity;

use App\Repository\AnimalRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AnimalRepository::class)
 */
class Animal
{
    
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $numero_identification;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $nom;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $date_naissance;

    /**
     * @ORM\Column(type="date")
     */
    private $date_arrivee;

    /**
     * @ORM\Column(type="boolean")
     */
    private $proprietaire;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $genre;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $espece;

    /**
     * @ORM\Column(type="boolean")
     */
    private $sterilise;

    /**
     * @ORM\Column(type="boolean")
     */
    private $quarantaine;

    /**
     * @ORM\ManyToOne(targetEntity=Enclos::class, inversedBy="animals")
     * @ORM\JoinColumn(nullable=false)
     */
    private $enclos;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumeroIdentification(): ?string
    {
        return $this->numero_identification;
    }

    public function setNumeroIdentification(int $numero_identification): self
    {
        $this->numero_identification = $numero_identification;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getDateNaissance(): ?\DateTimeInterface
    {
        return $this->date_naissance;
    }

    public function setDateNaissance(?\DateTimeInterface $date_naissance): self
    {
        $this->date_naissance = $date_naissance;

        return $this;
    }

    public function getDateArrivee(): ?\DateTimeInterface
    {
        return $this->date_arrivee;
    }

    public function setDateArrivee(\DateTimeInterface $date_arrivee): self
    {
        $this->date_arrivee = $date_arrivee;

        return $this;
    }

    public function isProprietaire(): ?bool
    {
        return $this->proprietaire;
    }

    public function setProprietaire(bool $proprietaire): self
    {
        $this->proprietaire = $proprietaire;

        return $this;
    }

    public function getGenre(): ?string
    {
        return $this->genre;
    }

    public function setGenre(string $genre): self
    {
        $this->genre = $genre;

        return $this;
    }

    public function getEspece(): ?string
    {
        return $this->espece;
    }

    public function setEspece(string $espece): self
    {
        $this->espece = $espece;

        return $this;
    }

    public function isSterilise(): ?bool
    {
        return $this->sterilise;
    }

    public function setSterilise(bool $sterilise): self
    {
        $this->sterilise = $sterilise;

        return $this;
    }

    public function isQuarantaine(): ?bool
    {
        return $this->quarantaine;
    }

    public function setQuarantaine(bool $quarantaine): self
    {
        $this->quarantaine = $quarantaine;

        return $this;
    }

    public function getEnclos(): ?Enclos
    {
        return $this->enclos;
    }

    public function setEnclos(?Enclos $enclos): self
    {
        $this->enclos = $enclos;

        return $this;
    }
}
