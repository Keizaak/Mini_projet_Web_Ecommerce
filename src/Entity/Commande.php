<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CommandeRepository")
 */
class Commande
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

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
     * @ORM\ManyToOne(targetEntity="Etat")
     * @ORM\JoinColumn(name="etat", referencedColumnName="id", nullable=true)
     *
     * @Assert\Type("object")
     *
     * @Assert\NotBlank(
     *     message="L'état ne doit pas être vide"
     * )
     */
    private $etat;

    /**
     * @ORM\Column(type="date", nullable=true)
     *
     * @Assert\NotBlank(
     *     message="La date de création ne doit pas être vide"
     * )
     *
     * @Assert\Date(
     *     message="La date de création doit être de format aaaa-mm-dd"
     * )
     */
    private $date;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\LigneCommande", mappedBy="commande", cascade={"persist", "remove"})
     */
    private $lignesCommande;

    public function __construct()
    {
        $this->lignesCommande = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(?\DateTimeInterface $date): self
    {
        $this->date = $date;

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


    public function getEtat(): ?Etat
    {
        return $this->etat;
    }

    public function setEtat(?Etat $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    /**
     * @return Collection|LigneCommande[]
     */
    public function getLignesCommande(): Collection
    {
        return $this->lignesCommande;
    }

    public function addLignesCommande(LigneCommande $lignesCommande): self
    {
        if (!$this->lignesCommande->contains($lignesCommande)) {
            $this->lignesCommande[] = $lignesCommande;
            $lignesCommande->setLignesCommande($this);
        }

        return $this;
    }

    public function removeLignesCommande(LigneCommande $lignesCommande): self
    {
        if ($this->lignesCommande->contains($lignesCommande)) {
            $this->lignesCommande->removeElement($lignesCommande);
            // set the owning side to null (unless already changed)
            if ($lignesCommande->getLignesCommande() === $this) {
                $lignesCommande->setLignesCommande(null);
            }
        }

        return $this;
    }
}
