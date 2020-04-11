<?php
declare(strict_types=1);

namespace Places\Controller;

use Places\Form\FilterType;
use Places\Repository\PlaceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $filterForm = $this->createForm(FilterType::class);
        $filterForm->handleRequest($request);

        if ($filterForm->isSubmitted() && $filterForm->isValid()) {
            $category = $filterForm->get('category')->getData();
            if (null !== $category) {
                $places = $this->placeRepository->findBy(['category' => $category]);
            } else {
                $places = $this->placeRepository->findAll();
            }
        } else {
            $places = $this->placeRepository->findAll();
        }
        return $this->render('/main/index.html.twig', [
            'places' => $places,
            'filterForm' => $filterForm->createView(),
        ]);
    }
}