<?php

namespace App\Controller;

use App\Entity\ExpoOeuvre;
use App\Form\ExpoOeuvreType;
use App\Repository\ExpoOeuvreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/expo/oeuvre")
 */
class ExpoOeuvreController extends AbstractController
{
    /**
     * @Route("/", name="expo_oeuvre_index", methods={"GET"})
     */
    public function index(ExpoOeuvreRepository $expoOeuvreRepository): Response
    {
        return $this->render('expo_oeuvre/index.html.twig', [
            'expo_oeuvres' => $expoOeuvreRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="expo_oeuvre_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $expoOeuvre = new ExpoOeuvre();
        $form = $this->createForm(ExpoOeuvreType::class, $expoOeuvre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($expoOeuvre);
            $entityManager->flush();

            return $this->redirectToRoute('expo_oeuvre_index');
        }

        return $this->render('expo_oeuvre/new.html.twig', [
            'expo_oeuvre' => $expoOeuvre,
            'form' => $form->createView(),
        ]);
    }

   /* /**
     * @Route("/{id}", name="expo_oeuvre_show", methods={"GET"})
     */
   /* public function show(ExpoOeuvre $expoOeuvre): Response
    {
        return $this->render('expo_oeuvre/show.html.twig', [
            'expo_oeuvre' => $expoOeuvre,
        ]);
    }*/

    /**
     * @Route("/{id}/edit", name="expo_oeuvre_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, ExpoOeuvre $expoOeuvre): Response
    {
        $form = $this->createForm(ExpoOeuvreType::class, $expoOeuvre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('expo_oeuvre_index');
        }

        return $this->render('expo_oeuvre/edit.html.twig', [
            'expo_oeuvre' => $expoOeuvre,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="expo_oeuvre_delete", methods={"POST"})
     */
    public function delete(Request $request, ExpoOeuvre $expoOeuvre): Response
    {
        if ($this->isCsrfTokenValid('delete'.$expoOeuvre->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($expoOeuvre);
            $entityManager->flush();
        }

        return $this->redirectToRoute('expo_oeuvre_index');
    }
}
