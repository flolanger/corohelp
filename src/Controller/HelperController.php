<?php

namespace Corohelp\Controller;

use Corohelp\Entity\Helper;
use Corohelp\Form\HelperType;
use Corohelp\Repository\HelperRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/helper")
 */
class HelperController extends AbstractController
{
    /**
     * @Route("/", name="helper_index", methods={"GET"})
     */
    public function index(HelperRepository $helperRepository): Response
    {
        return $this->render('helper/index.html.twig', [
            'helpers' => $helperRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="helper_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $helper = new Helper();
        $form = $this->createForm(HelperType::class, $helper);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($helper);
            $entityManager->flush();

            return $this->redirectToRoute('helper_index');
        }

        return $this->render('helper/new.html.twig', [
            'helper' => $helper,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="helper_show", methods={"GET"})
     */
    public function show(Helper $helper): Response
    {
        return $this->render('helper/show.html.twig', [
            'helper' => $helper,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="helper_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Helper $helper): Response
    {
        $form = $this->createForm(HelperType::class, $helper);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('helper_index');
        }

        return $this->render('helper/edit.html.twig', [
            'helper' => $helper,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="helper_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Helper $helper): Response
    {
        if ($this->isCsrfTokenValid('delete'.$helper->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($helper);
            $entityManager->flush();
        }

        return $this->redirectToRoute('helper_index');
    }
}
