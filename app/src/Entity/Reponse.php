<?php

namespace App\Entity;

use App\Repository\ReponseRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReponseRepository::class)]
class Reponse
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'reponses')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Question $question = null;

    #[ORM\ManyToOne(inversedBy: 'reponses')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Dieu $dieu = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $reponseText = null;

    #[ORM\Column]
    private ?int $point = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuestion(): ?Question
    {
        return $this->question;
    }

    public function setQuestion(?Question $question): static
    {
        $this->question = $question;

        return $this;
    }

    public function getDieu(): ?Dieu
    {
        return $this->dieu;
    }

    public function setDieu(?Dieu $dieu): static
    {
        $this->dieu = $dieu;

        return $this;
    }

    public function getReponseText(): ?string
    {
        return $this->reponseText;
    }

    public function setReponseText(string $reponseText): static
    {
        $this->reponseText = $reponseText;

        return $this;
    }

    public function getPoint(): ?int
    {
        return $this->point;
    }

    public function setPoint(int $point): static
    {
        $this->point = $point;

        return $this;
    }
}
