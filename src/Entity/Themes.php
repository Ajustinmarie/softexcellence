<?php

namespace App\Entity;

use App\Repository\ThemesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ThemesRepository::class)
 */
class Themes
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
    private $nom;

    /**
     * @ORM\OneToMany(targetEntity=OutilVba::class, mappedBy="Themes")
     */
    private $outilVbas;

    public function __construct()
    {
        $this->outilVbas = new ArrayCollection();
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

    /**
     * @return Collection<int, OutilVba>
     */
    public function getOutilVbas(): Collection
    {
        return $this->outilVbas;
    }

    public function addOutilVba(OutilVba $outilVba): self
    {
        if (!$this->outilVbas->contains($outilVba)) {
            $this->outilVbas[] = $outilVba;
            $outilVba->setThemes($this);
        }

        return $this;
    }

    public function removeOutilVba(OutilVba $outilVba): self
    {
        if ($this->outilVbas->removeElement($outilVba)) {
            // set the owning side to null (unless already changed)
            if ($outilVba->getThemes() === $this) {
                $outilVba->setThemes(null);
            }
        }

        return $this;
    }
}
