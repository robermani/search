<?php

namespace App\Entity;

use App\Repository\SearchResultRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SearchResultRepository::class)]
class SearchResult
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private string $searchEngine;

    #[ORM\Column(length: 500)]
    private string $title;

    #[ORM\Column(type: 'datetime_immutable')]
    private \DateTimeImmutable $enteredDate;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSearchEngine(): string
    {
        return $this->searchEngine;
    }

    public function setSearchEngine(string $searchEngine): self
    {
        $this->searchEngine = $searchEngine;
        return $this;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;
        return $this;
    }

    public function getEnteredDate(): \DateTimeImmutable
    {
        return $this->enteredDate;
    }

    public function setEnteredDate(\DateTimeImmutable $enteredDate): self
    {
        $this->enteredDate = $enteredDate;
        return $this;
    }
}
