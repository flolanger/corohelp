<?php

namespace Places\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="Places\Repository\PlaceRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Place extends AbstractEntity
{
    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    protected string $title = '';

    /**
     * @var string
     *
     * @ORM\Column(type="text")
     */
    protected string $description = '';

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    protected string $location = '';

    /**
     * @var float
     *
     * @ORM\Column(type="float", nullable=true)
     */
    protected ?float $rating = null;

    /**
     * @var Category
     *
     * @ORM\ManyToOne(targetEntity="Places\Entity\Category", inversedBy="places")
     */
    protected ?Category $category = null;

    /**
     * @var UserInterface
     *
     * @ORM\ManyToOne(targetEntity="Places\Entity\User", inversedBy="places")
     * @ORM\JoinColumn(nullable=false)
     */
    private UserInterface $user;

    /**
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return $this
     */
    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return $this
     */
    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return string
     */
    public function getLocation(): string
    {
        return $this->location;
    }

    /**
     * @param string $location
     * @return self
     */
    public function setLocation(string $location): Place
    {
        $this->location = $location;
        return $this;
    }

    /**
     * @return float
     */
    public function getRating(): float
    {
        return $this->rating;
    }

    /**
     * @param float $rating
     * @return self
     */
    public function setRating(float $rating): Place
    {
        $this->rating = $rating;
        return $this;
    }

    /**
     * @return Category|null
     */
    public function getCategory(): ?Category
    {
        return $this->category;
    }

    /**
     * @param Category|null $category
     * @return $this
     */
    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return UserInterface
     */
    public function getUser(): UserInterface
    {
        return $this->user;
    }

    /**
     * @param UserInterface $user
     * @return self
     */
    public function setUser(UserInterface $user): self
    {
        $this->user = $user;

        return $this;
    }
}
