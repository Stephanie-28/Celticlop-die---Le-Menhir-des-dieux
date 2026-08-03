<?php

namespace App\Entity;

use App\Repository\SymboleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SymboleRepository::class)]
class Symbole
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $img = null;

    /**
     * @var Collection<int, Dieu>
     */
    #[ORM\ManyToMany(targetEntity: Dieu::class, mappedBy: 'symboles')]
    private Collection $dieux;

    public function __construct()
    {
        $this->dieux = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getImg(): ?string
    {
        return $this->img;
    }

    public function setImg(?string $img): static
    {
        $this->img = $img;

        return $this;
    }

    /**
     * @return Collection<int, Dieu>
     */
    public function getDieux(): Collection
    {
        return $this->dieux;
    }

    public function addDieu(Dieu $dieu): static
    {
        if (!$this->dieux->contains($dieu)) {
            $this->dieux->add($dieu);
            $dieu->addSymbole($this);
        }

        return $this;
    }

    public function removeDieu(Dieu $dieu): static
    {
        if ($this->dieux->removeElement($dieu)) {
            $dieu->removeSymbole($this);
        }

        return $this;
    }
}
