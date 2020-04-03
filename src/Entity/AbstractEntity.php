<?php

namespace Corohelp\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class AbstractEntity
 */
abstract class AbstractEntity
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
     * @var DateTime
     * @ORM\Column(type="datetime")
     */
    protected DateTime $creationDate;

    /**
     * @var DateTime
     * @ORM\Column(type="datetime")
     */
    protected DateTime $updatedDate;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return DateTime
     */
    public function getCreationDate(): DateTime
    {
        return $this->creationDate;
    }

    /**
     * @param DateTime $creationDate
     * @return self
     */
    public function setCreationDate(DateTime $creationDate): AbstractEntity
    {
        $this->creationDate = $creationDate;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getUpdatedDate(): DateTime
    {
        return $this->updatedDate;
    }

    /**
     * @param DateTime $updatedDate
     * @return self
     */
    public function setUpdatedDate(DateTime $updatedDate): AbstractEntity
    {
        $this->updatedDate = $updatedDate;
        return $this;
    }

    /**
     * @ORM\PrePersist()
     */
    public function updateCreationDate()
    {
        $this->creationDate = new DateTime();
    }

    /**
     * @ORM\PreUpdate()
     */
    public function updateUpdatedDate()
    {
        $this->updatedDate = new DateTime();
    }
}
