<?php

namespace Corohelp\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Class DefaultController
 */
class DefaultController extends AbstractController
{
    public function index()
    {
        return $this->render('base.html.twig', [
        ]);
    }
}