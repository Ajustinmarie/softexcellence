<?php

namespace App\Entity;

use App\Repository\CommandeDetailRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CommandeDetailRepository::class)
 */
class CommandeDetail
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $id_utilisateur;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $date_creation;

    /**
     * @ORM\Column(type="integer")
     */
    private $id_outil_vba;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantite;

    /**
     * @ORM\Column(type="float")
     */
    private $prix;

    /**
     * @ORM\Column(type="float")
     */
    private $total;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $commande_paye;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $numero_commande;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $payment_id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $payer_id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $payment_status;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $purchased_at;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $payer_email;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdUtilisateur(): ?int
    {
        return $this->id_utilisateur;
    }

    public function setIdUtilisateur(int $id_utilisateur): self
    {
        $this->id_utilisateur = $id_utilisateur;

        return $this;
    }

    public function getDateCreation(): ?string
    {
        return $this->date_creation;
    }

    public function setDateCreation(string $date_creation): self
    {
        $this->date_creation = $date_creation;

        return $this;
    }

    public function getIdOutilVba(): ?int
    {
        return $this->id_outil_vba;
    }

    public function setIdOutilVba(int $id_outil_vba): self
    {
        $this->id_outil_vba = $id_outil_vba;

        return $this;
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

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getTotal(): ?float
    {
        return $this->total;
    }

    public function setTotal(float $total): self
    {
        $this->total = $total;

        return $this;
    }

    public function getCommandePaye(): ?bool
    {
        return $this->commande_paye;
    }

    public function setCommandePaye(?bool $commande_paye): self
    {
        $this->commande_paye = $commande_paye;

        return $this;
    }

    public function getNumeroCommande(): ?string
    {
        return $this->numero_commande;
    }

    public function setNumeroCommande(?string $numero_commande): self
    {
        $this->numero_commande = $numero_commande;

        return $this;
    }

    public function getPaymentId(): ?string
    {
        return $this->payment_id;
    }

    public function setPaymentId(?string $payment_id): self
    {
        $this->payment_id = $payment_id;

        return $this;
    }

    public function getPayerId(): ?string
    {
        return $this->payer_id;
    }

    public function setPayerId(?string $payer_id): self
    {
        $this->payer_id = $payer_id;

        return $this;
    }

    public function getPaymentStatus(): ?string
    {
        return $this->payment_status;
    }

    public function setPaymentStatus(?string $payment_status): self
    {
        $this->payment_status = $payment_status;

        return $this;
    }

    public function getPurchasedAt(): ?\DateTimeInterface
    {
        return $this->purchased_at;
    }

    public function setPurchasedAt(?\DateTimeInterface $purchased_at): self
    {
        $this->purchased_at = $purchased_at;

        return $this;
    }

    public function getPayerEmail(): ?string
    {
        return $this->payer_email;
    }

    public function setPayerEmail(?string $payer_email): self
    {
        $this->payer_email = $payer_email;

        return $this;
    }
}
