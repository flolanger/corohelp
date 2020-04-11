<?php
declare(strict_types=1);

namespace Places\Controller;

use Places\Repository\PlaceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class MainController
 */
class MainController extends AbstractController
{
    /**
     * @var PlaceRepository
     */
    protected PlaceRepository $placeRepository;

    public function __construct(PlaceRepository $placeRepository)
    {
        $this->placeRepository = $placeRepository;
    }

    /**
     * @return Response
     */
    public function index()
    {
        return $this->render('/main/index.html.twig', [
            'places' => $this->placeRepository->findAll(),
        ]);
    }
}