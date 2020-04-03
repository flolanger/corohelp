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
}
