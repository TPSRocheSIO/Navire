<?php

namespace App\Entity;

use App\Repository\PaysRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table (name:'pays')]
#[Assert\Unique(fields: ['indicatif'])]
#[ORM\Entity(repositoryClass: PaysRepository::class)]
#[ORM\Index(name:'ind_indicatif', columns: ['indicatif'])]    
class Pays
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 70)]
    private ?string $nom = null;

    #[ORM\Column(length: 3, name: 'indicatif')]
    #[Assert\Regex('/[A-Z]{3}/', message : 'L\'indicatif doit contenir uniquement 3 lettres majuscules')]
    private ?string $indicatif = null;
    
     #[ORM\OneToMany(mappedBy: 'port', targetEntity: Escale::class, orphanRemoval: true)]
     private Collection $escales;

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
}
