<?php

namespace App\Controller;

use App\Entity\Event;
use App\Entity\Reservationevent;
use App\Form\ReservationeventType;
use App\Repository\ReservationeventRepository;
use mysql_xdevapi\RowResult;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Dompdf\Dompdf;
use Dompdf\Options;
use MercurySeries\FlashyBundle\FlashyNotifier;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use function MongoDB\BSON\toJSON;
use App\Services\QrcodeService;


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
        $u=$this->getUser();
        $reservationeventsRepository = $this->getDoctrine()
            ->getRepository(Reservationevent::class)
            ->findByClient($u);



        /* $reservationevents = $this->getDoctrine()
             ->getManager()
             ->getRepository(Reservationevent::class)
             ->SortReservation();*/

        return $this->render('reservationevent/index.html.twig', [
            'reservationevents' => $reservationeventsRepository,
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
    public function new(Request $request, Event $Event, \Swift_Mailer $mailer,QrcodeService $qrcodeService): Response
    {
        $qrCode = null;
        $reservationevent = new Reservationevent();
        $u=$this->getUser();
        $reservationevent->setCodeClient($u);
        $form = $this->createForm(ReservationeventType::class, $reservationevent);
        $reservationevent->setCodeEvent($Event);
        $form->handleRequest($request);

        $this->addFlash('success', 'Only '.$Event->getNbMaxPart().' place(s) left !!');

        if ($form->isSubmitted() && $form->isValid() ) {
            if ($Event->getNbMaxPart() >= $reservationevent->getNbPlace()) {
                $Event->setNbMaxPart($Event->getNbMaxPart()-$reservationevent->getNbPlace());
                $this->getDoctrine()->getManager()->flush();

                $u=$this->getUser();
                $reservationevent->setCodeClient($u);
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($reservationevent);
                $entityManager->flush();
                $m="Good Day Mr/Mrs ".$reservationevent->getCodeClient()->getNom().",
                 Your reservation of ".$reservationevent->getNbPlace()." place(s) for ".$reservationevent->getCodeEvent()->getNomEvent()." has been confirmed.
                 Thank you for choosing ArtDome.
                 ";
                $message = (new \Swift_Message('Reservation confirmed'))
                    ->setFrom('artdomeproject@gmail.com')
                    ->setTo($reservationevent->getCodeClient()->getEmail())
                    ->setBody($m);
                $mailer->send($message);
                $qrCode = $qrcodeService->qrcode($m,$reservationevent->getCodeReservation());
                //$this->sendSms($reservationevent->getCodeEvent()->getDate(),$reservationevent->getCodeClient()->getPrenom(),$reservationevent->getCodeEvent()->getNomEvent());
                return $this->redirectToRoute('reservationevent_index');
            }
            else

                $this->addFlash('success', 'It seems like you exceeded the maximum participation range, please try again with fewer places');
        }

        return $this->render('reservationevent/new.html.twig', [
            'reservationevent' => $reservationevent,
            'form' => $form->createView(),
            'qrCode' => $qrCode
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
    public function edit(Request $request, Reservationevent $reservationevent,QrcodeService $qrcodeService): Response
    {
        $qrCode = null;
        $form = $this->createForm(ReservationeventType::class, $reservationevent);
        $form->handleRequest($request);

        $count1=$reservationevent->getNbPlace();

        $this->addFlash('success', 'Only '.$reservationevent->getCodeEvent()->getNbMaxPart().' place(s) left !!');

        if ($form->isSubmitted() && $form->isValid()) {
            if($reservationevent->getNbPlace()>$count1)
            {
                $place=$reservationevent->getNbPlace()-$count1;
            }
            else{
                $place=$count1-$reservationevent->getNbPlace();
            }
            if ($reservationevent->getCodeEvent()->getNbMaxPart() >= $place) {
                $reservationevent->getCodeEvent()->setNbMaxPart(($reservationevent->getCodeEvent()->getNbMaxPart())-$place);
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($reservationevent->getCodeEvent());
                $entityManager->flush();

                $this->getDoctrine()->getManager()->flush();
                $m="Good Day Mr/Mrs ".$reservationevent->getCodeClient()->getNom().",
                 Your reservation of ".$reservationevent->getNbPlace()." place(s) for ".$reservationevent->getCodeEvent()->getNomEvent()." has been confirmed.
                 Thank you for choosing ArtDome.
                 ";
                $qrCode = $qrcodeService->qrcode($m,$reservationevent->getCodeReservation());
                return $this->redirectToRoute('reservationevent_index');
            }
            else

                $this->addFlash('success', 'It seems like you exceeded the maximum participation range, please try again with fewer places');


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
    public function delete(Request $request, Reservationevent $reservationevent, \Swift_Mailer $mailer): Response
    {
        if ($this->isCsrfTokenValid('delete'.$reservationevent->getCodeReservation(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($reservationevent);
            $entityManager->flush();
            $m="Good Day Mr/Mrs ".$reservationevent->getCodeClient()->getNom().",
                 Your reservation of ".$reservationevent->getNbPlace()." place(s) for ".$reservationevent->getCodeEvent()->getNomEvent()." has been cancelled .
                 We hope to see you in upcoming events.
                 Thank you for choosing ArtDome.
                 ";
            $message = (new \Swift_Message('Reservation cancelled'))
                ->setFrom('artdomeproject@gmail.com')
                ->setTo($reservationevent->getCodeClient()->getEmail())
                ->setBody($m);
            $mailer->send($message);
        }

        return $this->redirectToRoute('reservationevent_index');
    }

    /**
     * @Route("/{codeReservation}/back", name="reservationevent_deleteBack", methods={"POST"})
     */
    public function deleteBack(Request $request, Reservationevent $reservationevent, \Swift_Mailer $mailer): Response
    {
        if ($this->isCsrfTokenValid('delete'.$reservationevent->getCodeReservation(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($reservationevent);
            $entityManager->flush();
            $m="Good Day Mr/Mrs ".$reservationevent->getCodeClient()->getNom().",
                 Your reservation of ".$reservationevent->getNbPlace()." place(s) for ".$reservationevent->getCodeEvent()->getNomEvent()." has been cancelled .
                 Please contact us for further information.
                 Thank you for choosing ArtDome.
                 ";
            $message = (new \Swift_Message('Reservation cancelled'))
                ->setFrom('artdomeproject@gmail.com')
                ->setTo($reservationevent->getCodeClient()->getEmail())
                ->setBody($m);
            $mailer->send($message);
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
            "Attachment" => true
        ]);
        return new Response('What a bewitching controller we have conjured!');
    }

    /**
     * @Route("/back/pdfBack", name="event_pdfRB", methods={"GET"})
     */


    public function pdfBack(ReservationeventRepository $reservationevents): Response
    {
        // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);
        //$reservationevents = $this->getDoctrine();
        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('reservationevent/ReservationPdfBack.html.twig', [

            'reservationevents' => $reservationevents->findAll(),

            'title' => "Events reservations"
        ]);


        // Load HTML to Dompdf
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        $dompdf->stream("ReservationBack.pdf", [
            "Attachment" => true
        ]);
        return new Response('What a bewitching controller we have conjured!');

    }

    /*  public function sendSms($date,$client,$event) {
          $twilio = $this->get("twilio.client");
          $text = "Good day ".$client." your reservation for  ".$event." on  ".$date."has been confirmed, thank you for choosing ArtDome." ;
          $twilio->messages->create("+21623850921", [
                  'from'=>'+15128655014', // From a Twilio number in your account
                  'body'=>$text]
          );
      }*/

    /**
     * @Route("//searchReservation ", name="reservationevent_searchReservationx")
     */
    public function searchReservationx(Request $request,NormalizerInterface $Normalizer)
    {

        $repository = $this->getDoctrine()->getRepository(Reservationevent::class);
        $requestString=$request->get('searchValue');
        $reservationevents = $repository->findReservationEventByName($requestString);
        $jsonContent = $Normalizer->normalize($reservationevents, 'json',['groups'=>'reservationevents:read']);
        $retour=json_encode($jsonContent);
        return new Response($retour);

    }

    /**
     * @Route("/back/searchReservation ", name="reservationevent_searchReservationxB")
     */
    public function searchReservationxB(Request $request,NormalizerInterface $Normalizer)
    {

        $repository = $this->getDoctrine()->getRepository(Reservationevent::class);
        $requestString=$request->get('searchValue');
        $reservationevents = $repository->findReservationEventByName($requestString);
        $jsonContent = $Normalizer->normalize($reservationevents, 'json',['groups'=>'reservationevents:read']);
        $retour=json_encode($jsonContent);
        return new Response($retour);

    }
}