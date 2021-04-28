<?php

namespace App\Controller;

use App\Entity\Exposition;
use App\Entity\ReservationExpo;
use App\Form\ReservationExpoType;
use App\Repository\ReservationExpoRepository;
use Doctrine\Persistence\Mapping\Driver\PHPDriver;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Services\QrcodeService;



/**
 * @Route("/reservation_expo")
 */
class ReservationExpoController extends AbstractController
{
    /**
     * @Route("/", name="reservation_expo_index", methods={"GET"})
     */
    public function index(): Response
    {
        $reservationExpos = $this->getDoctrine()
            ->getManager()
            ->createQuery('SELECT r FROM App\Entity\ReservationExpo r  where r.codeClient= :codeClient  order by  r.codeReservatione desc')
            ->setParameter('codeClient',$this->getUser())
            ->getResult();

        return $this->render('reservation_expo/index.html.twig', [
            'reservation_expos' => $reservationExpos,
        ]);
    }
    /**
     * @Route("/back", name="reservation_expo_indexBack", methods={"GET"})
     */
    public function indexBack(): Response
    {
       /* $reservationExpos = $this->getDoctrine()
            ->getRepository(ReservationExpo::class)
            ->findAll();*/

        $ReservationExpoRepository = $this->getDoctrine()
            ->getManager()
            ->getRepository(ReservationExpo::class);
        $reservationExpos = $ReservationExpoRepository->SortReservation1();


        return $this->render('reservation_expo/indexBack.html.twig', [
            'reservation_expos' => $reservationExpos,
        ]);
    }

    /**
     * @Route("/new/{codeExpo}", name="reservation_expo_new", methods={"GET","POST"})
     */
    public function new(Request $request, \Swift_Mailer $mailer, Exposition $exposition, QrcodeService $qrcodeService): Response
    {
        $qrCode = null;
        $reservationExpo = new ReservationExpo();
        $u=$this->getUser();
        $reservationExpo->setCodeClient($u);
        $form = $this->createForm(ReservationExpoType::class, $reservationExpo);
        $reservationExpo->setCodeExpo($exposition);
        $form->handleRequest($request);

        $this->addFlash('success', 'Only '.$exposition->getNbMaxParticipant().' place(s) left !!');

        /*$code=$exposition->getCodeExpo();
        $entityManager = $this->getDoctrine()->getManager();
        $query = $entityManager->createQuery('SELECT sum(e.nbPlace) FROM App\Entity\ReservationExpo e WHERE e.codeExpo='.$code.' ');
        $sum = $query->execute();
        $s=json_encode($sum);
        $count =$reservationExpo->getCodeExpo()->getNbMaxParticipant();
        $count1=$count-intval($s);//*/

        if ($form->isSubmitted() && $form->isValid()) {
            if ($exposition->getNbMaxParticipant() >= $reservationExpo->getNbPlace()) {
                $exposition->setNbMaxParticipant($exposition->getNbMaxParticipant()-$reservationExpo->getNbPlace());

                $this->getDoctrine()->getManager()->flush();

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($reservationExpo);
                $entityManager->flush();

                $m="Good Day Mr/Mrs ".$reservationExpo->getCodeClient()->getNom().",
                 Your reservation of ".$reservationExpo->getNbPlace()." place(s) for ".$reservationExpo->getCodeExpo()->getNomExpo()." has been confirmed.
                 Thank you for choosing ArtDome.
                 ";

                $message = (new \Swift_Message('Reservation confirmed'))
                    ->setFrom('artdomeproject@gmail.com')
                    ->setTo($reservationExpo->getCodeClient()->getEmail())
                    ->setBody($m);

                /*$flashy->success('Reservation created!', 'http://your-awesome-link.com');*/
                $mailer->send($message);
                $qrCode = $qrcodeService->qrcode($m,$reservationExpo->getCodeReservatione());
                return $this->redirectToRoute('reservation_expo_index');
            } else

                $this->addFlash('success', 'It seems like you exceeded the maximum participation range, please try again with fewer places');
        }

        return $this->render('reservation_expo/new.html.twig', [
            'reservation_expo' => $reservationExpo,
            'form' => $form->createView(),
            'qrCode' => $qrCode
        ]);
    }

    /**
     * @Route("/newBack", name="reservation_expo_newBack", methods={"GET","POST"})
     */
    public function newBack(Request $request): Response
    {
        $reservationExpo = new ReservationExpo();
        $form = $this->createForm(ReservationExpoType::class, $reservationExpo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($reservationExpo);
            $entityManager->flush();

            return $this->redirectToRoute('reservation_expo_indexBack');
        }

        return $this->render('reservation_expo/newBack.html.twig', [
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
     * @Route("/{codeReservatione}/back", name="reservation_expo_showBack", methods={"GET"})
     */
    public function showBack(ReservationExpo $reservationExpo): Response
    {
        return $this->render('reservation_expo/showBack.html.twig', [
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
     * @Route("/{codeReservatione}/editBack", name="reservation_expo_editBack", methods={"GET","POST"})
     */
    public function editBack(Request $request, ReservationExpo $reservationExpo): Response
    {
        $form = $this->createForm(ReservationExpoType::class, $reservationExpo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid() ) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('reservation_expo_indexBack');
        }

        return $this->render('reservation_expo/editBack.html.twig', [
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

    /**
     * @Route("/{codeReservatione}/back", name="reservation_expo_deleteBack", methods={"POST"})
     */
    public function deleteBack(Request $request, ReservationExpo $reservationExpo): Response
    {
        if ($this->isCsrfTokenValid('delete'.$reservationExpo->getCodeReservatione(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($reservationExpo);
            $entityManager->flush();
        }

        return $this->redirectToRoute('reservation_expo_indexBack');
    }



    /**
     * @Route("/reservation/pdf", name="pdf", methods={"GET"})
     */
    public function pdf(ReservationExpoRepository $ReservationExpoRepository): Response
    {
        // Configure Dompdf according to your needs
        $pdfOptions = new Options();

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);
        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('reservation_expo/liste.html.twig', [
            'reservation_expos' => $ReservationExpoRepository->findAll(),
        ]);

        // Load HTML to Dompdf
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (inline view)
        $dompdf->stream("pdfreservation.pdf", [
            "Attachment" => true
        ]);
        return new Response('What a bewitching controller we have conjured!');
    }

    /**
     * @Route("/reservation/pdf/back", name="pdf_aa", methods={"GET"})
     */
    public function pdfBack(ReservationExpoRepository $ReservationExpoRepository): Response
    {
        // Configure Dompdf according to your needs
        $pdfOptions = new Options();

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);
        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('reservation_expo/liste.html.twig', [
            'reservation_expos' => $ReservationExpoRepository->findAll(),
        ]);

        // Load HTML to Dompdf
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (inline view)
        $dompdf->stream("pdfreservationBack.pdf", [
            "Attachment" => true
        ]);
        return new Response('What a bewitching controller we have conjured!');
    }
    /**
     * @Route("/expo/search", name="reservation_expo_searchReservation")
     */
    public function searchReservation(Request $request, NormalizerInterface $Normalizer)
    {
        $repository = $this->getDoctrine()->getRepository(ReservationExpo::class);
        $requestString= $request->get('searchValue');
        $reservations = $repository->findreservationByCode($requestString);
        $jsonContent = $Normalizer->normalize($reservations, 'json',['groups'=>'reservations:read']);
        $retour=json_encode($jsonContent);
        return new Response($retour);

    }

    /**
     * @Route("//searchBack", name="reservation_expo_searchReservationBack")
     */
    public function searchReservationBack(Request $request, NormalizerInterface $Normalizer)
    {
        $repository = $this->getDoctrine()->getRepository(ReservationExpo::class);
        $requestString= $request->get('searchValue');
        $reservations = $repository->findreservationByCode($requestString);
        $jsonContent = $Normalizer->normalize($reservations, 'json',['groups'=>'reservations:read']);
        $retour=json_encode($jsonContent);
        return new Response($retour);

    }


}
