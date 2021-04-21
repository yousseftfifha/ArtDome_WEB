<?php

namespace App\Controller;

use App\Entity\Reservationevent;
use App\Form\ReservationeventType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/reservationevent")
 */
class ReservationeventController extends AbstractController
{
    /**
     * @Route("/", name="reservationevent_index", methods={"GET"})
     */
    public function index(): Response
    {
        $reservationevents = $this->getDoctrine()
            ->getRepository(Reservationevent::class)
            ->findAll();

        return $this->render('reservationevent/index.html.twig', [
            'reservationevents' => $reservationevents,
        ]);
    }

    /**
     * @Route("/back", name="reservationevent_indexBack", methods={"GET"})
     */
    public function indexBack(): Response
    {
        $reservationevents = $this->getDoctrine()
            ->getRepository(Reservationevent::class)
            ->findAll();

        return $this->render('reservationevent/indexBack.html.twig', [
            'reservationevents' => $reservationevents,
        ]);
    }

    /**
     * @Route("/new", name="reservationevent_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $reservationevent = new Reservationevent();
        $form = $this->createForm(ReservationeventType::class, $reservationevent);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($reservationevent);
            $entityManager->flush();

            return $this->redirectToRoute('reservationevent_index');
        }

        return $this->render('reservationevent/new.html.twig', [
            'reservationevent' => $reservationevent,
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/newBack", name="reservationevent_newBack", methods={"GET","POST"})
     */
    public function newBack(Request $request): Response
    {
        $reservationevent = new Reservationevent();
        $form = $this->createForm(ReservationeventType::class, $reservationevent);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($reservationevent);
            $entityManager->flush();

            return $this->redirectToRoute('reservationevent_indexBack');
        }

        return $this->render('reservationevent/newBack.html.twig', [
            'reservationevent' => $reservationevent,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{codeReservation}", name="reservationevent_show", methods={"GET"})
     */
    public function show(Reservationevent $reservationevent): Response
    {
        return $this->render('reservationevent/show.html.twig', [
            'reservationevent' => $reservationevent,
        ]);
    }

    /**
     * @Route("/{codeReservation}/back", name="reservationevent_showBack", methods={"GET"})
     */
    public function showBack(Reservationevent $reservationevent): Response
    {
        return $this->render('reservationevent/showBack.html.twig', [
            'reservationevent' => $reservationevent,
        ]);
    }

    /**
     * @Route("/{codeReservation}/edit", name="reservationevent_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Reservationevent $reservationevent): Response
    {
        $form = $this->createForm(ReservationeventType::class, $reservationevent);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('reservationevent_index');
        }

        return $this->render('reservationevent/edit.html.twig', [
            'reservationevent' => $reservationevent,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{codeReservation}/editBack", name="reservationevent_editBack", methods={"GET","POST"})
     */
    public function editBack(Request $request, Reservationevent $reservationevent): Response
    {
        $form = $this->createForm(ReservationeventType::class, $reservationevent);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('reservationevent_indexBack');
        }

        return $this->render('reservationevent/editBack.html.twig', [
            'reservationevent' => $reservationevent,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{codeReservation}", name="reservationevent_delete", methods={"POST"})
     */
    public function delete(Request $request, Reservationevent $reservationevent): Response
    {
        if ($this->isCsrfTokenValid('delete'.$reservationevent->getCodeReservation(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($reservationevent);
            $entityManager->flush();
        }

        return $this->redirectToRoute('reservationevent_index');
    }

    /**
     * @Route("/{codeReservation}/back", name="reservationevent_deleteBack", methods={"POST"})
     */
    public function deleteBack(Request $request, Reservationevent $reservationevent): Response
    {
        if ($this->isCsrfTokenValid('delete'.$reservationevent->getCodeReservation(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($reservationevent);
            $entityManager->flush();
        }

        return $this->redirectToRoute('reservationevent_indexBack');
    }
}
