<?php

namespace App\Entity;

use App\Repository\EscaleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EscaleRepository::class)]
class Escale
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(name:'dateHeureArrivee', type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateHeureArrivee = null;

    #[ORM\Column(name:'dateHeureDepart', type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateHeureDepart = null;

    #[ORM\ManyToOne(inversedBy: 'escales')]
    #[ORM\JoinColumn(name:'idnavire', referencedColumnName: 'id', nullable: false)]
    private ?Navire $navire = null;
    
    #[ORM\ManyToOne(inversedBy: 'escales')]
    #[ORM\JoinColumn(name:'idport', referencedColumnName: 'id', nullable: false)]
    private ?Port $port = null;


    public function __construct()
    {
        $this->navire = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateHeureArrivee(): ?\DateTimeInterface
    {
        return $this->dateHeureArrivee;
    }

    public function setDateHeureArrivee(\DateTimeInterface $dateHeureArrivee): self
    {
        $this->dateHeureArrivee = $dateHeureArrivee;

        return $this;
    }

    public function getDateHeureDepart(): ?\DateTimeInterface
    {
        return $this->dateHeureDepart;
    }

    public function setDateHeureDepart(?\DateTimeInterface $dateHeureDepart): self
    {
        $this->dateHeureDepart = $dateHeureDepart;

        return $this;
    }

    /**
     * @return Collection<int, Navire>
     */
    public function getNavire(): Collection
    {
        return $this->navire;
    }

    public function addNavire(Navire $navire): self
    {
        if (!$this->navire->contains($navire)) {
            $this->navire->add($navire);
            $navire->setEscales($this);
        }

        return $this;
    }

    public function removeNavire(Navire $navire): self
    {
        if ($this->navire->removeElement($navire)) {
            // set the owning side to null (unless already changed)
            if ($navire->getEscales() === $this) {
                $navire->setEscales(null);
            }
        }

        return $this;
    }
}
