<?php

namespace Corohelp\Controller;

use Corohelp\Entity\Helper;
use Corohelp\Form\HelperType;
use Corohelp\Repository\HelperRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class HelperController
 */
class HelperController extends AbstractController
{
    /**
     * @param \Corohelp\Repository\HelperRepository $helperRepository
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(HelperRepository $helperRepository): Response
    {
        return $this->render('helper/index.html.twig', [
            'helpers' => $helperRepository->findAll(),
        ]);
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return \Symfony\Component\HttpFoundation\Response
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
     * @param \Corohelp\Entity\Helper $helper
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function show(Helper $helper): Response
    {
        return $this->render('helper/show.html.twig', [
            'helper' => $helper,
        ]);
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param \Corohelp\Entity\Helper $helper
     * @return \Symfony\Component\HttpFoundation\Response
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
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param \Corohelp\Entity\Helper $helper
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function delete(Request $request, Helper $helper): Response
    {
        if ($this->isCsrfTokenValid('delete' . $helper->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($helper);
            $entityManager->flush();
        }

        return $this->redirectToRoute('helper_index');
    }
}
