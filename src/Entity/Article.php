<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ArticleRepository")
 */
class Article
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=100, unique=true)
     */
    private $slug;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $content;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $pulishedAt;

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    private $author;

    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private $heartCount = 0;

    /**
     * @var string
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $imageFileName;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getPulishedAt(): ?\DateTimeInterface
    {
        return $this->pulishedAt;
    }

    public function setPulishedAt(?\DateTimeInterface $pulishedAt): self
    {
        $this->pulishedAt = $pulishedAt;

        return $this;
    }

    /**
     * @return string
     */
    public function getAuthor(): string
    {
        return $this->author;
    }

    /**
     * @param string $author
     * @return Article
     */
    public function setAuthor(string $author): Article
    {
        $this->author = $author;
        
        return $this;
    }

    /**
     * @return int
     */
    public function getHeartCount(): int
    {
        return $this->heartCount;
    }

    /**
     * @param int $heartCount
     * @return Article
     */
    public function setHeartCount(int $heartCount): Article
    {
        $this->heartCount = $heartCount;
        return $this;
    }

    /**
     * @return string
     */
    public function getImageFileName(): string
    {
        return $this->imageFileName;
    }

    /**
     * @param string $imageFileName
     * @return Article
     */
    public function setImageFileName(string $imageFileName): Article
    {
        $this->imageFileName = $imageFileName;
        
        return $this;
    }

    /**
     * @return string
     */
    public function getImagePath(): string
    {
        return 'images/' . $this->getImageFileName();
    }

    /**
     * @return $this
     */
    public function incrementHeartCount(): self
    {
        $this->heartCount = $this->heartCount + 1;

        return $this;
    }
}
