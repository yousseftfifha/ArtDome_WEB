<?php

namespace App\Controller;

use App\Entity\ReservationExpo;
use App\Form\ReservationExpoType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/reservation/expo")
 */
class ReservationExpoController extends AbstractController
{
    /**
     * @Route("/", name="reservation_expo_index", methods={"GET"})
     */
    public function index(): Response
    {
        $reservationExpos = $this->getDoctrine()
            ->getRepository(ReservationExpo::class)
            ->findAll();

        return $this->render('reservation_expo/index.html.twig', [
            'reservation_expos' => $reservationExpos,
        ]);
    }
    /**
     * @Route("/back", name="reservation_expo_indexBack", methods={"GET"})
     */
    public function indexBack(): Response
    {
        $reservationExpos = $this->getDoctrine()
            ->getRepository(ReservationExpo::class)
            ->findAll();

        return $this->render('reservation_expo/indexBack.html.twig', [
            'reservation_expos' => $reservationExpos,
        ]);
    }

    /**
     * @Route("/new", name="reservation_expo_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $reservationExpo = new ReservationExpo();
        $form = $this->createForm(ReservationExpoType::class, $reservationExpo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($reservationExpo);
            $entityManager->flush();

            return $this->redirectToRoute('reservation_expo_index');
        }

        return $this->render('reservation_expo/new.html.twig', [
            'reservation_expo' => $reservationExpo,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{codeReservatione}", name="reservation_expo_show", methods={"GET"})
     */
    public function show(ReservationExpo $reservationExpo): Response
    {
        return $this->render('reservation_expo/show.html.twig', [
            'reservation_expo' => $reservationExpo,
        ]);
    }

    /**
     * @Route("/{codeReservatione}/edit", name="reservation_expo_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, ReservationExpo $reservationExpo): Response
    {
        $form = $this->createForm(ReservationExpoType::class, $reservationExpo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('reservation_expo_index');
        }

        return $this->render('reservation_expo/edit.html.twig', [
            'reservation_expo' => $reservationExpo,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{codeReservatione}", name="reservation_expo_delete", methods={"POST"})
     */
    public function delete(Request $request, ReservationExpo $reservationExpo): Response
    {
        if ($this->isCsrfTokenValid('delete'.$reservationExpo->getCodeReservatione(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($reservationExpo);
            $entityManager->flush();
        }

        return $this->redirectToRoute('reservation_expo_index');
    }
}
