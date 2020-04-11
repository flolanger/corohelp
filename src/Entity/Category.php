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
     * @ORM\OneToMany(targetEntity="Places\Entity\Seeker", mappedBy="category")
     */
    protected Collection $seekers;

    public function __construct()
    {
        $this->seekers = new ArrayCollection();
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
    public function getSeekers(): Collection
    {
        return $this->seekers;
    }

    /**
     * @param Seeker $seeker
     * @return $this
     */
    public function addSeeker(Seeker $seeker): self
    {
        if (!$this->seekers->contains($seeker)) {
            $this->seekers[] = $seeker;
            $seeker->setCategory($this);
        }

        return $this;
    }

    /**
     * @param Seeker $seeker
     * @return $this
     */
    public function removeSeeker(Seeker $seeker): self
    {
        if ($this->seekers->contains($seeker)) {
            $this->seekers->removeElement($seeker);
            // set the owning side to null (unless already changed)
            if ($seeker->getCategory() === $this) {
                $seeker->setCategory(null);
            }
        }

        return $this;
    }
}
