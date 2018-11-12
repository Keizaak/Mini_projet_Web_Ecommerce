<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LigneCommandeRepository")
 */
class LigneCommande
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Commande", inversedBy="lignesCommande")
     * @ORM\JoinColumn(name="commande", referencedColumnName="id", nullable=true)
     *
     * @Assert\Type("object")
     *
     * @Assert\NotBlank(
     *     message="La commande ne doit pas être vide"
     * )
     */
    private $commande;

    /**
     * @ORM\ManyToOne(targetEntity="Produit")
     * @ORM\JoinColumn(name="produit", referencedColumnName="id", nullable=true)
     *
     * @Assert\Type("object")
     *
     * @Assert\NotBlank(
     *     message="Le produit ne doit pas être vide"
     * )
     */
    private $produit;


    /**
     * @ORM\Column(type="integer")
     *
     * @Assert\Type(type="float")
     *
     * @Assert\NotBlank(
     *     message="La quantité ne doit pas être vide"
     * )
     *
     *
     */
    private $quantite;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantite(): ?int
    {
        return $this->quantite;
    }

    public function setQuantite(int $quantite): self
    {
        $this->quantite = $quantite;

        return $this;
    }

    public function getCommande(): ?Commande
    {
        return $this->commande;
    }

    public function setCommande(?Commande $commande): self
    {
        $this->commande = $commande;

        return $this;
    }

    public function getProduit(): ?Produit
    {
        return $this->produit;
    }

    public function setProduit(?Produit $produit): self
    {
        $this->produit = $produit;

        return $this;
    }
}
