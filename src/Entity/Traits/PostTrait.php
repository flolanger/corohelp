<?php

namespace Corohelp\Entity\Traits;

use Corohelp\Entity\Category;
use Doctrine\ORM\Mapping as ORM;

trait PostTrait
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
     * @var Category
     *
     * @ORM\ManyToOne(targetEntity="Corohelp\Entity\Category", inversedBy="seekers")
     */
    protected ?Category $category = null;

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
}