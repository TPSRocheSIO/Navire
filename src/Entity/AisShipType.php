<?php

namespace App\Entity;

use App\Repository\AisShipTypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name :'aisshiptype')]
#[ORM\Entity(repositoryClass: AisShipTypeRepository::class)]
class AisShipType
{
    #[Assert\Unique(fields:['aisShipType'])]
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column (name:'id')]
    private ?int $id = null;

    #[ORM\Column (name:'aisshiptype')]
    #[Assert\Range(
            min: 1,
            max: 9,
            notInRangeMessage : 'Le type AIS doit être compris entre {{ min }} et {{ max }}'
    )]
        
    private ?int $aisShipType = null;

    #[ORM\Column(length: 60)]
    private ?string $libelle = null;
    
    #[ORM\OneToMany(mappedBy: 'aisShipType', targetEntity: Navire::class)]
    private Collection $navires;

    #[ORM\ManyToMany(targetEntity: Port::class, mappedBy: 'types')]
    private Collection $portCompatibles;

    public function __construct()
    {
        $this->portCompatibles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAisShipType(): ?int
    {
        return $this->aisShipType;
    }

    public function setAisShipType(int $aisShipType): self
    {
        $this->aisShipType = $aisShipType;

        return $this;
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
     * @return Collection<int, Port>
     */
    public function getPortCompatibles(): Collection
    {
        return $this->portCompatibles;
    }

    public function addPortCompatible(Port $portCompatible): self
    {
        if (!$this->portCompatibles->contains($portCompatible)) {
            $this->portCompatibles->add($portCompatible);
        }

        return $this;
    }

    public function removePortCompatible(Port $portCompatible): self
    {
        $this->portCompatibles->removeElement($portCompatible);

        return $this;
    }
}
