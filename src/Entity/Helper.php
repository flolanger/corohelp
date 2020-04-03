<?php

namespace Corohelp\Entity;

use Corohelp\Entity\Traits\PostTrait;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="Corohelp\Repository\HelperRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Helper extends AbstractEntity
{
    use PostTrait;

    /**
     * @var Category
     *
     * @ORM\ManyToOne(targetEntity="Corohelp\Entity\Category", inversedBy="helpers")
     */
    protected ?Category $category = null;

    /**
     * @var UserInterface
     *
     * @ORM\ManyToOne(targetEntity="Corohelp\Entity\User", inversedBy="helpers")
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
