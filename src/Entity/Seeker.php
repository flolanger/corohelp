<?php

namespace Corohelp\Entity;

use Corohelp\Entity\Traits\PostTrait;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Corohelp\Repository\SeekerRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Seeker extends AbstractEntity
{
    use PostTrait;

    /**
     * @var Category
     *
     * @ORM\ManyToOne(targetEntity="Corohelp\Entity\Category", inversedBy="seekers")
     */
    protected ?Category $category = null;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="Corohelp\Entity\User", inversedBy="seekers")
     * @ORM\JoinColumn(nullable=false)
     */
    private User $user;

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User $user
     * @return self
     */
    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
