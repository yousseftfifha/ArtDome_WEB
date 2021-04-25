<?php

namespace App\Controller;

use App\Entity\Endroit;
use App\Form\EndroitType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/endroit")
 */
class EndroitController extends AbstractController
{
    /**
     * @Route("/", name="endroit_index", methods={"GET"})
     */
    public function index(): Response
    {
        $endroits = $this->getDoctrine()
            ->getRepository(Endroit::class)
            ->findAll();

        return $this->render('endroit/index.html.twig', [
            'endroits' => $endroits,
        ]);
    }

    /**
     * @Route("/new", name="endroit_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $endroit = new Endroit();
        $form = $this->createForm(EndroitType::class, $endroit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($endroit);
            $entityManager->flush();

            return $this->redirectToRoute('endroit_index');
        }

        return $this->render('endroit/new.html.twig', [
            'endroit' => $endroit,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idEndroit}", name="endroit_show", methods={"GET"})
     */
    public function show(Endroit $endroit): Response
    {
        return $this->render('endroit/show.html.twig', [
            'endroit' => $endroit,
        ]);
    }

    /**
     * @Route("/{idEndroit}/edit", name="endroit_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Endroit $endroit): Response
    {
        $form = $this->createForm(EndroitType::class, $endroit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('endroit_index');
        }

        return $this->render('endroit/edit.html.twig', [
            'endroit' => $endroit,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idEndroit}", name="endroit_delete", methods={"POST"})
     */
    public function delete(Request $request, Endroit $endroit): Response
    {
        if ($this->isCsrfTokenValid('delete'.$endroit->getIdEndroit(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($endroit);
            $entityManager->flush();
        }

        return $this->redirectToRoute('endroit_index');
    }
}
