<?php

namespace App\Controller;

use App\Entity\Event;
use App\Entity\Reservationevent;
use App\Form\ReservationeventType;
use App\Repository\ReservationeventRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Dompdf\Dompdf;
use Dompdf\Options;
use MercurySeries\FlashyBundle\FlashyNotifier;

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
        //$reservationevents = $this->getDoctrine()
            /*->getRepository(Reservationevent::class)
            ->findAll();//
            ->getManager()
            ->createQuery('SELECT r FROM App\Entity\Reservationevent r order by  r.codeReservation desc')
            ->getResult();*/

        $reservationeventsRepository = $this->getDoctrine()
            ->getManager()
            ->getRepository(Reservationevent::class);
        $reservationevents = $reservationeventsRepository->SortReservation();

        return $this->render('reservationevent/index.html.twig', [
            'reservationevents' => $reservationevents,
        ]);
    }

    /**
     * @Route("/back", name="reservationevent_indexBack", methods={"GET"})
     */
    public function indexBack(): Response
    {
        //$reservationevents = $this->getDoctrine()
            /*->getRepository(Reservationevent::class)
            ->findAll();//
            ->getManager()
            ->createQuery('SELECT r FROM App\Entity\Reservationevent r order by  r.codeReservation desc')
            ->getResult();*/

        $reservationeventsRepository = $this->getDoctrine()
            ->getManager()
            ->getRepository(Reservationevent::class);
        $reservationevents = $reservationeventsRepository->SortReservation();

        return $this->render('reservationevent/indexBack.html.twig', [
            'reservationevents' => $reservationevents,
        ]);
    }

    /**
     * @Route("/new/{codeEvent}", name="reservationevent_new", methods={"GET","POST"})
     */
    public function new(Request $request, Event $Event, \Swift_Mailer $mailer, FlashyNotifier $flashy): Response
    {
        $reservationevent = new Reservationevent();
        $form = $this->createForm(ReservationeventType::class, $reservationevent);
        $reservationevent->setCodeEvent($Event);
        $form->handleRequest($request);

        /*$entityManager = $this->getDoctrine()->getManager();
        $query = $entityManager->createQuery('SELECT count(e)*e.nb_place FROM App\Entity\Reservationevent e WHERE e.code_event='+$Event->getCodeEvent()+' ');
        $count = $query->execute();
        && $reservationevent->getNbPlace()<$count*/

        if ($form->isSubmitted() && $form->isValid() ) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($reservationevent);
            $entityManager->flush();

            $message = (new \Swift_Message('Reservation confirmed'))
                ->setFrom('artdomeproject@gmail.com')
                ->setTo($reservationevent->getCodeClient()->getEmail())
                ->setBody("Good Day Mr/Mrs,
                
                                Your reservation has been confirmed.
                                
                                Thank you for choosing ArtDome.
                "
                );
            $flashy->success('Reservation created!', 'http://your-awesome-link.com');
            $mailer->send($message);

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

    /**
     * @Route("/{codeReservation}/pdf", name="pdfR", methods={"GET"})
     */

    public function pdf(Reservationevent $reservationevent)
    {
        // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);

        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('reservationevent/ReservationPdf.html.twig', [

                'reservationevent' => $reservationevent, 'title' => "Event reservation"
            ]);


        // Load HTML to Dompdf
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        $dompdf->stream("Reservation.pdf", [
            "Attachment" => false
        ]);
    }
/*
    /**
     * @Route("/pdfBack", name="pdfRB", methods={"GET"})
     */

/*
    public function pdfBack(Reservationevent $reservationevents)
    {
        // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);
        $reservationevents = $this->getDoctrine();
        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('reservationevent/ReservationPdfBack.html.twig', [

            'reservationevents' => $reservationevents->findAll(),
            'reservationevents' => $reservationevents
            ,'title' => "Events reservations"
        ]);


        // Load HTML to Dompdf
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        $dompdf->stream("ReservationBack.pdf", [
            "Attachment" => false
        ]);
    }*/
}
