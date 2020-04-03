<?php

namespace Corohelp\Entity;

use Corohelp\Entity\Traits\PostTrait;
use Doctrine\ORM\Mapping as ORM;

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
}
