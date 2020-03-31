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
     * @ORM\OneToMany(targetEntity="Corohelp\Entity\Seeker", mappedBy="category")
     */
    private $seekers;

    /**
     * @ORM\OneToMany(targetEntity="Corohelp\Entity\Helper", mappedBy="category")
     */
    private $helpers;

    public function __construct()
    {
        $this->seekers = new ArrayCollection();
        $this->helpers = new ArrayCollection();
    }

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

    /**
     * @return Collection|Seeker[]
     */
    public function getSeekers(): Collection
    {
        return $this->seekers;
    }

    public function addSeeker(Seeker $seeker): self
    {
        if (!$this->seekers->contains($seeker)) {
            $this->seekers[] = $seeker;
            $seeker->setCategory($this);
        }

        return $this;
    }

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
     * @return Collection|Helper[]
     */
    public function getHelpers(): Collection
    {
        return $this->helpers;
    }

    public function addHelper(Helper $helper): self
    {
        if (!$this->helpers->contains($helper)) {
            $this->helpers[] = $helper;
            $helper->setCategory($this);
        }

        return $this;
    }

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
