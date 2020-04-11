<?php
declare(strict_types=1);

namespace Places\Controller;

use Places\Repository\HelperRepository;
use Places\Repository\SeekerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class MainController
 */
class MainController extends AbstractController
{
    /**
     * @var SeekerRepository
     */
    protected SeekerRepository $seekerRepository;

    /**
     * @var HelperRepository
     */
    protected HelperRepository $helperRepository;

    public function __construct(SeekerRepository $seekerRepository, HelperRepository $helperRepository)
    {
        $this->seekerRepository = $seekerRepository;
        $this->helperRepository = $helperRepository;
    }

    /**
     * @return Response
     */
    public function index()
    {
        return $this->render('/main/index.html.twig', [
            'seekers' => $this->seekerRepository->findAll(),
            'helpers' => $this->helperRepository->findAll(),
        ]);
    }
}