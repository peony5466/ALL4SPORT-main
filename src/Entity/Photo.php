<?php

namespace App\Entity;

use App\Repository\PhotoRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PhotoRepository::class)]
class Photo
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private $libelle = null;

    #[ORM\ManyToOne(inversedBy: 'photos')]
    private ?Produits $fk_produit = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle()
    {
        return $this->libelle;
    }

    public function setLibelle($libelle): static
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getFkProduit(): ?Produits
    {
        return $this->fk_produit;
    }

    public function setFkProduit(?Produits $fk_produit): static
    {
        $this->fk_produit = $fk_produit;

        return $this;
    }
}
