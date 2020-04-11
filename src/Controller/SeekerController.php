<?php

namespace Places\Controller;

use Places\Entity\Seeker;
use Places\Form\SeekerType;
use Places\Repository\SeekerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class SeekerController
 */
class SeekerController extends AbstractController
{
    /**
     * @param SeekerRepository $seekerRepository
     * @return Response
     */
    public function index(SeekerRepository $seekerRepository): Response
    {
        return $this->render('seeker/index.html.twig', [
            'seekers' => $seekerRepository->findAll(),
        ]);
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $seeker = new Seeker();
        $form = $this->createForm(SeekerType::class, $seeker);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $seeker->setUser($this->getUser());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($seeker);
            $entityManager->flush();

            return $this->redirectToRoute('seeker_index');
        }

        return $this->render('seeker/new.html.twig', [
            'seeker' => $seeker,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @param Seeker $seeker
     * @return Response
     */
    public function show(Seeker $seeker): Response
    {
        return $this->render('seeker/show.html.twig', [
            'seeker' => $seeker,
        ]);
    }

    /**
     * @param Request $request
     * @param Seeker $seeker
     * @return Response
     */
    public function edit(Request $request, Seeker $seeker): Response
    {
        $form = $this->createForm(SeekerType::class, $seeker);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('seeker_index');
        }

        return $this->render('seeker/edit.html.twig', [
            'seeker' => $seeker,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @param Request $request
     * @param Seeker $seeker
     * @return Response
     */
    public function delete(Request $request, Seeker $seeker): Response
    {
        if ($this->isCsrfTokenValid('delete' . $seeker->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($seeker);
            $entityManager->flush();
        }

        return $this->redirectToRoute('seeker_index');
    }
}
