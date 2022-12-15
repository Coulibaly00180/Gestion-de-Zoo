<?php

namespace App\Entity;

use App\Repository\EspaceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EspaceRepository::class)
 */
class Espace
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\Column(type="smallint")
     */
    private $superficie;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $date_ouverture;

    /**
     * @ORM\Column(type="date", nullable=true)
     * @ORM\Expression(
     *      "this.getDateOuverture() < this.getDateFermeture()",
     *      message = "La date fin ne doit pas être antérieure à la date début"
     * )
     */
    private $date_fermeture;

    /**
     * @ORM\OneToMany(targetEntity=Enclos::class, mappedBy="espace")
     */
    private $enclos;

    public function __construct()
    {
        $this->enclos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getSuperficie(): ?int
    {
        return $this->superficie;
    }

    public function setSuperficie(int $superficie): self
    {
        $this->superficie = $superficie;

        return $this;
    }

    public function getDateOuverture(): ?\DateTimeInterface
    {
        return $this->date_ouverture;
    }

    public function setDateOuverture(?\DateTimeInterface $date_ouverture): self
    {
        $this->date_ouverture = $date_ouverture;

        return $this;
    }

    public function getDateFermeture(): ?\DateTimeInterface
    {
        return $this->date_fermeture;
    }

    public function setDateFermeture(?\DateTimeInterface $date_fermeture): self
    {
        $this->date_fermeture = $date_fermeture;

        return $this;
    }

    /**
     * @return Collection<int, Enclos>
     */
    public function getEnclos(): Collection
    {
        return $this->enclos;
    }

    public function addEnclo(Enclos $enclo): self
    {
        if (!$this->enclos->contains($enclo)) {
            $this->enclos[] = $enclo;
            $enclo->setEspace($this);
        }

        return $this;
    }

    public function removeEnclo(Enclos $enclo): self
    {
        if ($this->enclos->removeElement($enclo)) {
            // set the owning side to null (unless already changed)
            if ($enclo->getEspace() === $this) {
                $enclo->setEspace(null);
            }
        }

        return $this;
    }
}
