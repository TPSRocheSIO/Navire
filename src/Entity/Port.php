<?php

namespace App\Entity;

use App\Repository\PortRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PortRepository::class)]
#[Assert\Unique(fields:['nom','indicatif'])]
#[ORM\Index(name:'ind_indicatif', columns: ['indicatif'])]
class Port
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 70)]
    private ?string $nom = null;

    #[ORM\Column(length: 5)]
    #[Assert\Regex('/[A-Z]{5}/', message : 'l\'indicatif Port a strictement 5 caractères')]
    private ?string $indicatif = null;

    #[ORM\ManyToMany(targetEntity: AisShipType::class, inversedBy: 'portCompatibles')]
    #[ORM\JoinTable(name:'porttypecompatible')]
    #[ORM\JoinColumn(name:'idport', referencedColumnName:'id')]
    #[ORM\InverseJoinColumn(name:'idaisshiptype',referencedColumnName: 'id')]
    private Collection $types;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(name:'idpays', nullable: false)]

    private ?Pays $pays = null;

    public function __construct()
    {
        $this->types = new ArrayCollection();
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

    public function getIndicatif(): ?string
    {
        return $this->indicatif;
    }

    public function setIndicatif(string $indicatif): self
    {
        $this->indicatif = $indicatif;

        return $this;
    }

    /**
     * @return Collection<int, AisShipType>
     */
    public function getTypes(): Collection
    {
        return $this->types;
    }

    public function addType(AisShipType $type): self
    {
        if (!$this->types->contains($type)) {
            $this->types->add($type);
            $type->addPortCompatible($this);
        }

        return $this;
    }

    public function removeType(AisShipType $type): self
    {
        if ($this->types->removeElement($type)) {
            $type->removePortCompatible($this);
        }

        return $this;
    }

    public function getPays(): ?Pays
    {
        return $this->pays;
    }

    public function setPays(?Pays $pays): self
    {
        $this->pays = $pays;

        return $this;
    }
}
