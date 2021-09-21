<?php

declare(strict_types=1);

namespace App\Entity;

use App\Model\Entity\ProfileInterface;
use App\Model\Entity\SearchRequestInterface;
use App\Repository\ProfileRepository;
use DateTimeImmutable;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProfileRepository::class)
 * @ORM\Table(
 *     name="profiles",
 *     uniqueConstraints={@ORM\UniqueConstraint(name="u_profiles_search_request_id",columns={"search_request_id"})},
 * )
 * @ORM\HasLifecycleCallbacks
 */
class Profile implements ProfileInterface
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="uuid", unique=true, nullable=false)
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="Ramsey\Uuid\Doctrine\UuidGenerator")
     */
    private ?string $id = null;

    /**
     * @ORM\Column(type="datetime", nullable=false, name="created_at")
     */
    private DateTimeInterface $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=false, name="updated_at")
     */
    private DateTimeInterface $updatedAt;

    /**
     * @ORM\OneToOne(targetEntity=SearchRequest::class, inversedBy="profile")
     * @ORM\JoinColumn(nullable=false, name="search_request_id", referencedColumnName="id")
     */
    private SearchRequestInterface $searchRequest;

    /**
     * @ORM\Column(type="json", options={"jsonb":true}, nullable=false)
     */
    private array $data;

    public function getCreatedAt(): DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getSearchRequest(): SearchRequestInterface
    {
        return $this->searchRequest;
    }

    public function setSearchRequest(SearchRequestInterface $searchRequest): self
    {
        $this->searchRequest = $searchRequest;

        return $this;
    }

    public function getData(): array
    {
        return $this->data;
    }

    public function setData(array $data): self
    {
        $this->data = $data;

        return $this;
    }

    /**
     * @ORM\PrePersist
     */
    public function setCreatedAtValue(): void
    {
        $this->createdAt = new DateTimeImmutable();
        $this->updatedAt = new DateTimeImmutable();
    }

    /**
     * @ORM\PreUpdate
     */
    public function setUpdatedAtValue(): void
    {
        $this->updatedAt = new DateTimeImmutable();
    }

    public function __toString(): string
    {
        return $this->getId();
    }

    public function getId(): string
    {
        return $this->id;
    }
}
