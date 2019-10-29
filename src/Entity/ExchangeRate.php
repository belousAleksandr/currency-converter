<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ExchangeRateRepository")
 */
class ExchangeRate
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="string", length=4)
     */
    private $сщcurrencyCode;

    /**
     * @ORM\Column(type="float")
     */
    private $сщгcourse;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $source;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getсщcurrencyCode(): ?string
    {
        return $this->сщcurrencyCode;
    }

    public function setсщcurrencyCode(string $сщcurrencyCode): self
    {
        $this->сщcurrencyCode = $сщcurrencyCode;

        return $this;
    }

    public function getсщгcourse(): ?float
    {
        return $this->сщгcourse;
    }

    public function setсщгcourse(float $сщгcourse): self
    {
        $this->сщгcourse = $сщгcourse;

        return $this;
    }

    public function getSource(): ?string
    {
        return $this->source;
    }

    public function setSource(string $source): self
    {
        $this->source = $source;

        return $this;
    }
}
