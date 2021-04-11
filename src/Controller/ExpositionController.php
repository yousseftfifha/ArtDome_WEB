<?php

namespace App\Controller;

use App\Entity\Exposition;
use App\Entity\User;
use App\Entity\Endroit;
use App\Form\ExpositionType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/exposition")
 */
class ExpositionController extends AbstractController
{
    /**
     * @Route("/", name="exposition_index", methods={"GET"})
     */
    public function index(): Response
    {
        $expositions = $this->getDoctrine()
            ->getRepository(Exposition::class)
            ->findAll();

        return $this->render('exposition/index.html.twig', [
            'expositions' => $expositions,
        ]);
    }

    /**
     * @Route("/new", name="exposition_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $exposition = new Exposition();
        $form = $this->createForm(ExpositionType::class, $exposition);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($exposition);
            $entityManager->flush();

            return $this->redirectToRoute('exposition_index');
        }

        return $this->render('exposition/new.html.twig', [
            'exposition' => $exposition,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{codeExpo}", name="exposition_show", methods={"GET"})
     */
    public function show(Exposition $exposition): Response
    {
        return $this->render('exposition/show.html.twig', [
            'exposition' => $exposition,
        ]);
    }

    /**
     * @Route("/{codeExpo}/edit", name="exposition_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Exposition $exposition): Response
    {
        $form = $this->createForm(ExpositionType::class, $exposition);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('exposition_index');
        }

        return $this->render('exposition/edit.html.twig', [
            'exposition' => $exposition,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{codeExpo}", name="exposition_delete", methods={"POST"})
     */
    public function delete(Request $request, Exposition $exposition): Response
    {
        if ($this->isCsrfTokenValid('delete'.$exposition->getCodeExpo(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($exposition);
            $entityManager->flush();
        }

        return $this->redirectToRoute('exposition_index');
    }
}