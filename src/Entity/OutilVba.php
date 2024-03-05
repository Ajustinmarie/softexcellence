<?php

namespace App\Entity;

use App\Repository\OutilVbaRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OutilVbaRepository::class)
 */
class OutilVba
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom_outil;

    /**
     * @ORM\Column(type="string", length=255)
     */

    private $Description;

    /**
     * @ORM\Column(type="float")
     */
    private $Prix;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Documentation;

    /**
     * @ORM\Column(type="text")
     */
    private $Video;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $image;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $pieces_jointes;

    /**
     * @ORM\ManyToOne(targetEntity=Themes::class, inversedBy="outilVbas")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Themes;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomOutil(): ?string
    {
        return $this->nom_outil;
    }

    public function setNomOutil(string $nom_outil): self
    {
        $this->nom_outil = $nom_outil;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(string $Description): self
    {
        $this->Description = $Description;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->Prix;
    }

    public function setPrix(float $Prix): self
    {
        $this->Prix = $Prix;

        return $this;
    }

    public function getDocumentation(): ?string
    {
        return $this->Documentation;
    }

    public function setDocumentation(string $Documentation): self
    {
        $this->Documentation = $Documentation;

        return $this;
    }

    public function getVideo(): ?string
    {
        return $this->Video;
    }

    public function setVideo(string $Video): self
    {
        $this->Video = $Video;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getPiecesJointes(): ?string
    {
        return $this->pieces_jointes;
    }

    public function setPiecesJointes(string $pieces_jointes): self
    {
        $this->pieces_jointes = $pieces_jointes;

        return $this;
    }

    public function getThemes(): ?Themes
    {
        return $this->Themes;
    }

    public function setThemes(?Themes $Themes): self
    {
        $this->Themes = $Themes;

        return $this;
    }
}
