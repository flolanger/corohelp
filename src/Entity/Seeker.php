<?php

namespace Places\Entity;

use Places\Entity\Traits\PostTrait;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="Places\Repository\SeekerRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Seeker extends AbstractEntity
{
    use PostTrait;

    /**
     * @var Category
     *
     * @ORM\ManyToOne(targetEntity="Places\Entity\Category", inversedBy="seekers")
     */
    protected ?Category $category = null;

    /**
     * @var UserInterface
     *
     * @ORM\ManyToOne(targetEntity="Places\Entity\User", inversedBy="seekers")
     * @ORM\JoinColumn(nullable=false)
     */
    private UserInterface $user;

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
