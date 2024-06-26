<?php

namespace App\Entity;

use App\Repository\ProduitsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProduitsRepository::class)]
class Produits
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom_produit = null;

    #[ORM\Column(length: 255)]
    private ?string $desp_produit = null;

    #[ORM\Column]
    private ?int $prix_produit = null;

    #[ORM\Column(length: 255)]
    private ?string $lieu_produit = null;

    #[ORM\ManyToOne(inversedBy: 'produits')]
    private ?Rayon $fk_rayon = null;

    #[ORM\OneToMany(mappedBy: 'fk_produit', targetEntity: Photo::class)]
    private Collection $photos;

    #[ORM\ManyToMany(targetEntity: Commande::class, mappedBy: 'fk_produits')]
    private Collection $commandes;

    #[ORM\ManyToMany(targetEntity: Commande::class, inversedBy: 'produits')]
    private Collection $fk_commande;

    // #[ORM\ManyToMany(targetEntity: commande::class, inversedBy: 'produits')]
    // private Collection $fk_produits;

    // #[ORM\ManyToMany(targetEntity: Commande::class, mappedBy: 'fk_produits')]
    // private Collection $commandes;

    public function __construct()
    {
        $this->photos = new ArrayCollection();
        $this->commandes = new ArrayCollection();
        $this->fk_commande = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomProduit(): ?string
    {
        return $this->nom_produit;
    }

    public function setNomProduit(string $nom_produit): static
    {
        $this->nom_produit = $nom_produit;

        return $this;
    }

    public function getDespProduit(): ?string
    {
        return $this->desp_produit;
    }

    public function setDespProduit(string $desp_produit): static
    {
        $this->desp_produit = $desp_produit;

        return $this;
    }

    public function getPrixProduit(): ?int
    {
        return $this->prix_produit;
    }

    public function setPrixProduit(int $prix_produit): static
    {
        $this->prix_produit = $prix_produit;

        return $this;
    }

    public function getLieuProduit(): ?string
    {
        return $this->lieu_produit;
    }

    public function setLieuProduit(string $lieu_produit): static
    {
        $this->lieu_produit = $lieu_produit;

        return $this;
    }

    public function getFkRayon(): ?Rayon
    {
        return $this->fk_rayon;
    }

    public function setFkRayon(?Rayon $fk_rayon): static
    {
        $this->fk_rayon = $fk_rayon;

        return $this;
    }

    /**
     * @return Collection<int, Photo>
     */
    public function getPhotos(): Collection
    {
        return $this->photos;
    }

    public function addPhoto(Photo $photo): static
    {
        if (!$this->photos->contains($photo)) {
            $this->photos->add($photo);
        }

        return $this;
    }

    public function removePhoto(Photo $photo): static
    {
        if ($this->photos->removeElement($photo)) {
            // set the owning side to null (unless already changed)
            if ($photo->getFkProduit() === $this) {
                $photo->setFkProduit(null);
            }
        }

        return $this;
    }






    /**
     * @return Collection<int, Commande>
     */
    public function getCommandes(): Collection
    {
        return $this->commandes;
    }

    public function addCommande(Commande $commande): static
    {
        if (!$this->commandes->contains($commande)) {
            $this->commandes->add($commande);
            $commande->addFkProduit($this);
        }

        return $this;
    }

    public function removeCommande(Commande $commande): static
    {
        if ($this->commandes->removeElement($commande)) {
            $commande->removeFkProduit($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Commande>
     */
    public function getFkCommande(): Collection
    {
        return $this->fk_commande;
    }

    public function addFkCommande(Commande $fkCommande): static
    {
        if (!$this->fk_commande->contains($fkCommande)) {
            $this->fk_commande->add($fkCommande);
        }

        return $this;
    }

    public function removeFkCommande(Commande $fkCommande): static
    {
        $this->fk_commande->removeElement($fkCommande);

        return $this;
    }
}
