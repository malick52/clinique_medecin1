<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ServiceRepository")
 */
class Service
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
     * @ORM\OneToMany(targetEntity="App\Entity\Medcin", mappedBy="services")
     */
    private $medcins;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Service", inversedBy="specialites")
     * @ORM\JoinColumn(nullable=false)
     */
    private $service;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Service", mappedBy="service")
     */
    private $specialites;

    public function __construct()
    {
        $this->medcins = new ArrayCollection();
        $this->specialites = new ArrayCollection();
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
            $medcin->setServices($this);
        }

        return $this;
    }

    public function removeMedcin(Medcin $medcin): self
    {
        if ($this->medcins->contains($medcin)) {
            $this->medcins->removeElement($medcin);
            // set the owning side to null (unless already changed)
            if ($medcin->getServices() === $this) {
                $medcin->setServices(null);
            }
        }

        return $this;
    }

    public function getService(): ?self
    {
        return $this->service;
    }

    public function setService(?self $service): self
    {
        $this->service = $service;

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getSpecialites(): Collection
    {
        return $this->specialites;
    }

    public function addSpecialite(self $specialite): self
    {
        if (!$this->specialites->contains($specialite)) {
            $this->specialites[] = $specialite;
            $specialite->setService($this);
        }

        return $this;
    }

    public function removeSpecialite(self $specialite): self
    {
        if ($this->specialites->contains($specialite)) {
            $this->specialites->removeElement($specialite);
            // set the owning side to null (unless already changed)
            if ($specialite->getService() === $this) {
                $specialite->setService(null);
            }
        }

        return $this;
    }
}
