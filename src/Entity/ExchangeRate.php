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
     * @ORM\Column(type="string", length=4)
     */
    private $currencyCodeFrom;

    /**
     * @ORM\Column(type="string", length=4)
     */
    private $currencyCodeTo;

    /**
     * @ORM\Column(type="float")
     */
    private $course;

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

    /**
     * @return string
     */
    public function getCurrencyCodeFrom(): string
    {
        return $this->currencyCodeFrom;
    }

    /**
     * @param string $currencyCodeFrom
     */
    public function setCurrencyCodeFrom(string $currencyCodeFrom)
    {
        $this->currencyCodeFrom = $currencyCodeFrom;
    }

    /**
     * @return string
     */
    public function getCurrencyCodeTo():string
    {
        return $this->currencyCodeTo;
    }

    /**
     * @param string $currencyCodeTo
     */
    public function setCurrencyCodeTo(string $currencyCodeTo)
    {
        $this->currencyCodeTo = $currencyCodeTo;
    }

    /**
     * @return mixed
     */
    public function getCourse()
    {
        return $this->course;
    }

    /**
     * @param mixed $course
     */
    public function setCourse($course)
    {
        $this->course = $course;
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
