<?php

namespace App\Entity;

use App\Enum\MytheCategory;
use App\Repository\MytheRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MytheRepository::class)]
class Mythe
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $content = null;

    #[ORM\Column(enumType: MytheCategory::class)]
    private ?MytheCategory $category = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $img = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    /**
     * @var Collection<int, Chronique>
     */
    #[ORM\OneToMany(targetEntity: Chronique::class, mappedBy: 'mythe')]
    private Collection $chroniques;

    /**
     * @var Collection<int, Dieu>
     */
    #[ORM\ManyToMany(targetEntity: Dieu::class, mappedBy: 'mythes')]
    private Collection $dieux;

    public function __construct()
    {
        $this->chroniques = new ArrayCollection();
        $this->dieux = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): static
    {
        $this->content = $content;

        return $this;
    }

    public function getCategory(): ?MytheCategory
    {
        return $this->category;
    }

    public function setCategory(MytheCategory $category): static
    {
        $this->category = $category;

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

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return Collection<int, Chronique>
     */
    public function getChroniques(): Collection
    {
        return $this->chroniques;
    }

    public function addChronique(Chronique $chronique): static
    {
        if (!$this->chroniques->contains($chronique)) {
            $this->chroniques->add($chronique);
            $chronique->setMythe($this);
        }

        return $this;
    }

    public function removeChronique(Chronique $chronique): static
    {
        if ($this->chroniques->removeElement($chronique)) {
            if ($chronique->getMythe() === $this) {
                $chronique->setMythe(null);
            }
        }

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
            $dieu->addMythe($this);
        }

        return $this;
    }

    public function removeDieu(Dieu $dieu): static
    {
        if ($this->dieux->removeElement($dieu)) {
            $dieu->removeMythe($this);
        }

        return $this;
    }
}
