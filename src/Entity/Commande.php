<?php

namespace App\Entity;

use App\Repository\CommandeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommandeRepository::class)]
class Commande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $libelle = null;

    #[ORM\Column]
    private ?int $quantite = null;

    #[ORM\ManyToMany(targetEntity: Produits::class, inversedBy: 'commandes')]
    private Collection $fk_produits;

    #[ORM\ManyToMany(targetEntity: Produits::class, mappedBy: 'fk_commande')]
    private Collection $produits;

    public function __construct()
    {
        $this->fk_produits = new ArrayCollection();
        $this->produits = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): static
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getQuantite(): ?int
    {
        return $this->quantite;
    }

    public function setQteCommande(int $quantite): static
    {
        $this->quantite = $quantite;

        return $this;
    }

    /**
     * @return Collection<int, Produits>
     */
    public function getProduits(): Collection
    {
        return $this->produits;
    }

    /**
     * @return Collection<int, Produits>
     */
    public function getFkProduits(): Collection
    {
        return $this->fk_produits;
    }

    public function addFkProduit(Produits $fkProduit): static
    {
        if (!$this->fk_produits->contains($fkProduit)) {
            $this->fk_produits->add($fkProduit);
        }

        return $this;
    }

    public function removeFkProduit(Produits $fkProduit): static
    {
        $this->fk_produits->removeElement($fkProduit);

        return $this;
    }

    public function addProduit(Produits $produit): static
    {
        if (!$this->produits->contains($produit)) {
            $this->produits->add($produit);
            $produit->addFkCommande($this);
        }

        return $this;
    }

    public function removeProduit(Produits $produit): static
    {
        if ($this->produits->removeElement($produit)) {
            $produit->removeFkCommande($this);
        }

        return $this;
    }






}
