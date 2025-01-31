<?php

namespace App\Entity;

use App\Repository\TaskRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TaskRepository::class)]
class Task
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nameTask = null;

    #[ORM\Column(length: 255)]
    private ?string $statusTask = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $beginDate = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $endDate = null;

    #[ORM\Column]
    private ?bool $isFinishedTask = null;

    #[ORM\Column]
    private ?bool $isSuccessTask = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNameTask(): ?string
    {
        return $this->nameTask;
    }

    public function setNameTask(string $nameTask): static
    {
        $this->nameTask = $nameTask;

        return $this;
    }

    public function getStatusTask(): ?string
    {
        return $this->statusTask;
    }

    public function setStatusTask(string $statusTask): static
    {
        $this->statusTask = $statusTask;

        return $this;
    }

    public function getBeginDate(): ?\DateTimeInterface
    {
        return $this->beginDate;
    }

    public function setBeginDate(\DateTimeInterface $beginDate): static
    {
        $this->beginDate = $beginDate;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(\DateTimeInterface $endDate): static
    {
        $this->endDate = $endDate;

        return $this;
    }

    public function isFinishedTask(): ?bool
    {
        return $this->isFinishedTask;
    }

    public function setFinishedTask(bool $isFinishedTask): static
    {
        $this->isFinishedTask = $isFinishedTask;

        return $this;
    }

    public function isSuccessTask(): ?bool
    {
        return $this->isSuccessTask;
    }

    public function setSuccessTask(bool $isSuccessTask): static
    {
        $this->isSuccessTask = $isSuccessTask;

        return $this;
    }
}
