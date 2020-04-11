<?php

namespace Places\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Places\Repository\CategoryRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Category extends AbstractEntity
{
    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    protected string $title = '';

    /**
     * @var Collection
     * @ORM\OneToMany(targetEntity="Places\Entity\Place", mappedBy="category")
     */
    protected Collection $places;

    public function __construct()
    {
        $this->places = new ArrayCollection();
    }

    /**
     * @return string
     */
    public function getTitle(): string
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
     * @return Collection
     */
    public function getPlaces(): Collection
    {
        return $this->places;
    }

    /**
     * @param Place $place
     * @return $this
     */
    public function addPlace(Place $place): self
    {
        if (!$this->places->contains($place)) {
            $this->places[] = $place;
            $place->setCategory($this);
        }

        return $this;
    }

    /**
     * @param Place $place
     * @return $this
     */
    public function removePlace(Place $place): self
    {
        if ($this->places->contains($place)) {
            $this->places->removeElement($place);
            // set the owning side to null (unless already changed)
            if ($place->getCategory() === $this) {
                $place->setCategory(null);
            }
        }

        return $this;
    }
}
