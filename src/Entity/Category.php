<?php

namespace Corohelp\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Corohelp\Repository\CategoryRepository")
 */
class Category
{
    /**
     * @var int
     *
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    protected int $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    protected string $title = '';

    /**
     * @var Collection
     * @ORM\OneToMany(targetEntity="Corohelp\Entity\Seeker", mappedBy="category")
     */
    protected Collection $seekers;

    /**
     * @var Collection
     * @ORM\OneToMany(targetEntity="Corohelp\Entity\Helper", mappedBy="category")
     */
    protected Collection $helpers;

    public function __construct()
    {
        $this->seekers = new ArrayCollection();
        $this->helpers = new ArrayCollection();
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * @return Collection
     */
    public function getHelpers(): Collection
    {
        return $this->helpers;
    }

    /**
     * @param Helper $helper
     * @return $this
     */
    public function addHelper(Helper $helper): self
    {
        if (!$this->helpers->contains($helper)) {
            $this->helpers[] = $helper;
            $helper->setCategory($this);
        }

        return $this;
    }

    /**
     * @param Helper $helper
     * @return $this
     */
    public function removeHelper(Helper $helper): self
    {
        if ($this->helpers->contains($helper)) {
            $this->helpers->removeElement($helper);
            // set the owning side to null (unless already changed)
            if ($helper->getCategory() === $this) {
                $helper->setCategory(null);
            }
        }

        return $this;
    }
}
