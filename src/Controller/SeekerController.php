<?php

namespace Corohelp\Controller;

use Corohelp\Entity\Seeker;
use Corohelp\Form\SeekerType;
use Corohelp\Repository\SeekerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/seeker")
 */
class SeekerController extends AbstractController
{
    /**
     * @Route("/", name="seeker_index", methods={"GET"})
     */
    public function index(SeekerRepository $seekerRepository): Response
    {
        return $this->render('seeker/index.html.twig', [
            'seekers' => $seekerRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="seeker_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $seeker = new Seeker();
        $form = $this->createForm(SeekerType::class, $seeker);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
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
     * @Route("/{id}", name="seeker_show", methods={"GET"})
     */
    public function show(Seeker $seeker): Response
    {
        return $this->render('seeker/show.html.twig', [
            'seeker' => $seeker,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="seeker_edit", methods={"GET","POST"})
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
     * @Route("/{id}", name="seeker_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Seeker $seeker): Response
    {
        if ($this->isCsrfTokenValid('delete'.$seeker->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($seeker);
            $entityManager->flush();
        }

        return $this->redirectToRoute('seeker_index');
    }
}
