<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PanierRepository")
 */
class Panier
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     *
     * @Assert\NotBlank(
     *     message="L'id ne doit pas être nul"
     * )
     */
    private $id;

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
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="user", referencedColumnName="id", nullable=true)
     *
     * @Assert\Type("object")
     *
     * @Assert\NotBlank(
     *     message="L'user ne doit pas être vide"
     * )
     */
    private $user;

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

    public function getProduit(): ?Produit
    {
        return $this->produit;
    }

    public function setProduit(?Produit $produit): self
    {
        $this->produit = $produit;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getQuantite()
    {
        return $this->quantite;
    }

    public function setQuantite($quantite): self
    {
        $this->quantite = $quantite;

        return $this;
    }
}
