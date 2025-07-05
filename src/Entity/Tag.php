<?php

namespace App\Entity;

use App\Repository\TagRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TagRepository::class)]
class Tag
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'tags')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Metatag $metatag = null;

    /**
     * @var Collection<int, sobject>
     */
    #[ORM\ManyToMany(targetEntity: sobject::class, inversedBy: 'tags')]
    private Collection $articles;

    public function __construct()
    {
        $this->articles = new ArrayCollection();
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

    public function getMetatag(): ?Metatag
    {
        return $this->metatag;
    }

    public function setMetatag(?Metatag $metatag): static
    {
        $this->metatag = $metatag;

        return $this;
    }

    /**
     * @return Collection<int, sobject>
     */
    public function getArticles(): Collection
    {
        return $this->articles;
    }

    public function addArticle(sobject $article): static
    {
        if (!$this->articles->contains($article)) {
            $this->articles->add($article);
        }

        return $this;
    }

    public function removeArticle(sobject $article): static
    {
        $this->articles->removeElement($article);

        return $this;
    }
}
