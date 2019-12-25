<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SpecialiteRepository")
 */
class Specialite
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $libelle;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Medcin", mappedBy="specialites")
     */
    private $medcins;

    public function __construct()
    {
        $this->medcins = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * @return Collection|Medcin[]
     */
    public function getMedcins(): Collection
    {
        return $this->medcins;
    }

    public function addMedcin(Medcin $medcin): self
    {
        if (!$this->medcins->contains($medcin)) {
            $this->medcins[] = $medcin;
            $medcin->addSpecialite($this);
        }

        return $this;
    }

    public function removeMedcin(Medcin $medcin): self
    {
        if ($this->medcins->contains($medcin)) {
            $this->medcins->removeElement($medcin);
            $medcin->removeSpecialite($this);
        }

        return $this;
    }
}
