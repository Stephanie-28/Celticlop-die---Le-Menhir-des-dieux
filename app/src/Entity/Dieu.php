<?php

namespace App\Entity;

use App\Repository\DieuRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DieuRepository::class)]
class Dieu
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $quote = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $img = null;

    /**
     * @var Collection<int, QuizResult>
     */
    #[ORM\OneToMany(targetEntity: QuizResult::class, mappedBy: 'dieu')]
    private Collection $quizResults;

    /**
     * @var Collection<int, Reponse>
     */
    #[ORM\OneToMany(targetEntity: Reponse::class, mappedBy: 'dieu')]
    private Collection $reponses;

    /**
     * @var Collection<int, Pantheons>
     */
    #[ORM\ManyToMany(targetEntity: Pantheons::class, inversedBy: 'dieux')]
    private Collection $pantheons;

    /**
     * @var Collection<int, Symbole>
     */
    #[ORM\ManyToMany(targetEntity: Symbole::class, inversedBy: 'dieux')]
    private Collection $symboles;

    /**
     * @var Collection<int, Animal>
     */
    #[ORM\ManyToMany(targetEntity: Animal::class, inversedBy: 'dieux')]
    private Collection $animaux;

    /**
     * @var Collection<int, Mythe>
     */
    #[ORM\ManyToMany(targetEntity: Mythe::class, inversedBy: 'dieux')]
    private Collection $mythes;

    #[ORM\OneToOne(inversedBy: 'dieu', cascade: ['persist', 'remove'])]
    private ?Music $music = null;

    public function __construct()
    {
        $this->quizResults = new ArrayCollection();
        $this->reponses = new ArrayCollection();
        $this->pantheons = new ArrayCollection();
        $this->symboles = new ArrayCollection();
        $this->animaux = new ArrayCollection();
        $this->mythes = new ArrayCollection();
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

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

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

    public function getQuote(): ?string
    {
        return $this->quote;
    }

    public function setQuote(?string $quote): static
    {
        $this->quote = $quote;

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
     * @return Collection<int, QuizResult>
     */
    public function getQuizResults(): Collection
    {
        return $this->quizResults;
    }

    public function addQuizResult(QuizResult $quizResult): static
    {
        if (!$this->quizResults->contains($quizResult)) {
            $this->quizResults->add($quizResult);
            $quizResult->setDieu($this);
        }

        return $this;
    }

    public function removeQuizResult(QuizResult $quizResult): static
    {
        if ($this->quizResults->removeElement($quizResult)) {
            // set the owning side to null (unless already changed)
            if ($quizResult->getDieu() === $this) {
                $quizResult->setDieu(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Reponse>
     */
    public function getReponses(): Collection
    {
        return $this->reponses;
    }

    public function addReponse(Reponse $reponse): static
    {
        if (!$this->reponses->contains($reponse)) {
            $this->reponses->add($reponse);
            $reponse->setDieu($this);
        }

        return $this;
    }

    public function removeReponse(Reponse $reponse): static
    {
        if ($this->reponses->removeElement($reponse)) {
            // set the owning side to null (unless already changed)
            if ($reponse->getDieu() === $this) {
                $reponse->setDieu(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Pantheons>
     */
    public function getPantheons(): Collection
    {
        return $this->pantheons;
    }

    public function addPantheon(Pantheons $pantheon): static
    {
        if (!$this->pantheons->contains($pantheon)) {
            $this->pantheons->add($pantheon);
        }

        return $this;
    }

    public function removePantheon(Pantheons $pantheon): static
    {
        $this->pantheons->removeElement($pantheon);

        return $this;
    }

    /**
     * @return Collection<int, Symbole>
     */
    public function getSymboles(): Collection
    {
        return $this->symboles;
    }

    public function addSymbole(Symbole $symbole): static
    {
        if (!$this->symboles->contains($symbole)) {
            $this->symboles->add($symbole);
        }

        return $this;
    }

    public function removeSymbole(Symbole $symbole): static
    {
        $this->symboles->removeElement($symbole);

        return $this;
    }

    /**
     * @return Collection<int, Animal>
     */
    public function getAnimaux(): Collection
    {
        return $this->animaux;
    }

    public function addAnimal(Animal $animal): static
    {
        if (!$this->animaux->contains($animal)) {
            $this->animaux->add($animal);
        }

        return $this;
    }

    public function removeAnimal(Animal $animal): static
    {
        $this->animaux->removeElement($animal);

        return $this;
    }

    /**
     * @return Collection<int, Mythe>
     */
    public function getMythes(): Collection
    {
        return $this->mythes;
    }

    public function addMythe(Mythe $mythe): static
    {
        if (!$this->mythes->contains($mythe)) {
            $this->mythes->add($mythe);
        }

        return $this;
    }

    public function removeMythe(Mythe $mythe): static
    {
        $this->mythes->removeElement($mythe);

        return $this;
    }

    public function getMusic(): ?Music
    {
        return $this->music;
    }

    public function setMusic(?Music $music): static
    {
        $this->music = $music;

        if ($music !== null && $music->getDieu() !== $this) {
            $music->setDieu($this);
        }

        return $this;
    }
}
