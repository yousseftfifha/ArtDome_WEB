<?php

namespace App\Controller;

use App\Entity\Oeuvre;
use App\Entity\Orders;
use App\Entity\PendingOrders;
use App\Entity\User;
use App\Form\Orders1Type;
use App\Repository\OrdersRepository;
use App\Services\QrcodeService;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\BarChart;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\ColumnChart;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\PieChart;
use Dompdf\Dompdf;
use Dompdf\Options;
use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Yamilovs\Bundle\SmsBundle\Service\ProviderManager;
use Knp\Snappy\Pdf as Snappy;

/**
 * @Route("/orders")
 */
class OrdersController extends AbstractController
{
    /**
     * @Route("/", name="orders_index", methods={"GET"})
     */
    public function index(PaginatorInterface $paginator,Request $request): Response
    {
        $orders = $this->getDoctrine()
            ->getManager()
            ->createQuery('SELECT e FROM App\Entity\Orders e  WHERE e.iduser = :iduser order by  e.orderdate desc')
            ->setParameter('iduser',$this->getUser())
            ->getResult();

        $show = $paginator->paginate(
            $orders,
            $request->query->get('page', 1)/*le numéro de la page à afficher*/,
            6/*nbre d'éléments par page*/

        );
        return $this->render('orders/index.html.twig', [
            'orders' => $show,
        ]);
    }

    /**
     * @Route("/new/{innonumber}", name="orders_new", methods={"GET","POST"})
     */
    public function new(Request $request, int $innonumber, \Swift_Mailer $mailer,ProviderManager $providerManager,QrcodeService $qrcodeService): Response
    {

        $order = new Orders();

        $entityManager = $this->getDoctrine()->getManager();
        $d = new \DateTime("2000-02-24");
        $u=$this->getUser();
        $order->setIduser($u);
        $query = $entityManager->createQuery('SELECT u FROM App\Entity\PendingOrders u WHERE u.innonumber = :innonumber'
        )->setParameter('innonumber', $innonumber);

        $y = rand(1000000, 9999999);
        $montant = 0;
        $PANIER = $query->getResult(); // array of CmsUser username and name values
        foreach ($PANIER as $p) {
            $product = $this->getDoctrine()
                ->getRepository(Oeuvre::class)
                ->find($p->getOeuvreid());
            $montant += $p->getQuantity() * $product->getPrixoeuvre();

            $order->setInnonumber($innonumber);
        }

        $datetime = new \DateTime('now');
        $order->setOrderdate($datetime);
        $order->setStatus("Pending");
        $order->setDueamount($montant);
        $entityManager->merge($order);
        $entityManager->flush();

        $message = (new \Swift_Message('Confirmation Order'))
            ->setFrom('artdomeproject@gmail.com')
            ->setTo('youssef.tfifha@esprit.tn')
            ->setBody(
                "Bonjour Mr/Mme " . $u->getNom() . $u->getPrenom() . " votre commande N°" . $order->getInnonumber() . "ayant comme montant "
                . $order->getDueamount() . "est confirmé"
            );

        $mailer->send($message);
        $m= "Bonjour Mr/Mme " . $u->getNom() . $u->getPrenom() . " votre commande N°" . $order->getInnonumber() . "ayant comme montant "
            . $order->getDueamount() . "est confirmé";
        $qrCode = $qrcodeService->qrcode($m,$order->getInnonumber());

        $this->addFlash('success', 'Your order is added!');

        return $this->redirectToRoute('orders_index');

    }

    /**
     * @Route("/{orderid}", name="orders_show", methods={"GET"})
     */
    public function show(Orders $order): Response
    {
        return $this->render('orders/show.html.twig', [
            'order' => $order,
        ]);
    }

    /**
     * @Route("/{orderid}/Confirm", name="orders_confirm", methods={"GET","POST"})
     */
    public function Confirm(Request $request, Orders $order): Response
    {

        $order->setStatus("Confirmed");
        $this->getDoctrine()->getManager()->flush();
        return $this->redirectToRoute('ordersback_index');

    }

    /**
     * @Route("/{orderid}/Cancel", name="orders_cancel", methods={"GET","POST"})
     */
    public function Cancel(Request $request, Orders $order): Response
    {

        $order->setStatus("Cancelled");
        $this->getDoctrine()->getManager()->flush();
        return $this->redirectToRoute('ordersback_index');

    }

    /**
     * @Route("/{orderid}", name="orders_delete", methods={"POST"})
     */
    public function delete(Request $request, Orders $order): Response
    {
        if ($this->isCsrfTokenValid('delete' . $order->getOrderid(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($order);
            $entityManager->flush();
        }

        return $this->redirectToRoute('orders_index');
    }

    /**
     * @Route("/orders/generate_pdf", name="generate_pdf")
     */
    public function generate_pdf(){

        $options = new Options();
        $options->set('defaultFont', 'Roboto');


        $dompdf = new Dompdf($options);
        $orders = $this->getDoctrine()
            ->getManager()
            ->createQuery('SELECT e FROM App\Entity\Orders e   order by  e.orderdate desc')
            ->getResult();

        $html = $this->renderView('orders/liste.html.twig', [
            'orders' => $orders
        ]);


        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $dompdf->stream("AllOrders.pdf", [
            "Attachment" => true
        ]);
        return new Response('What a bewitching controller we have conjured!');
    }
    /**
     * @Route("/orders/generate_pdfUser", name="generate_pdfUser")
     */
    public function generate_pdfUser(){

        $options = new Options();
        $options->set('defaultFont', 'Arial');

        $dompdf = new Dompdf($options);
        $orders = $this->getDoctrine()
            ->getManager()
            ->createQuery('SELECT e FROM App\Entity\Orders e  WHERE e.iduser = :iduser order by  e.orderdate desc')
            ->setParameter('iduser',$this->getUser())
            ->getResult();

        $html = $this->renderView('orders/liste.html.twig', [
            'orders' => $orders
        ]);


        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $dompdf->stream("orders.pdf", [
            "Attachment" => true
        ]);
        return new Response('What a bewitching controller we have conjured!');

    }

    /**
     * @Route("/orders/orderbyDueAmount", name="orderbyDueAmount")
     */

    public function orderbyDueAmount(PaginatorInterface $paginator,Request $request)
    {
        $orders = $this->getDoctrine()
            ->getManager()
            ->createQuery('SELECT e FROM App\Entity\Orders e where e.iduser = :iduser order by  e.dueamount desc ')
            ->setParameter('iduser',$this->getUser())
            ->getResult();

        $show = $paginator->paginate(
            $orders,
            $request->query->get('page', 1)/*le numéro de la page à afficher*/,
            6/*nbre d'éléments par page*/

        );
        return $this->render('orders/index.html.twig', [
            'orders' => $show,
        ]);

    }

    /**
     * @Route("/orders/orderbyStatusPending", name="orderbyStatusPending")
     */

    public function orderbyStatusPending(PaginatorInterface $paginator,Request $request)
    {
        $orders = $this->getDoctrine()
            ->getManager()
            ->createQuery('SELECT e FROM App\Entity\Orders e WHERE e.status = :status and  e.iduser = :iduser'
            )->setParameter('status', "Pending")
            ->setParameter('iduser',$this->getUser())

            ->getResult();

        $show = $paginator->paginate(
            $orders,
            $request->query->get('page', 1)/*le numéro de la page à afficher*/,
            6/*nbre d'éléments par page*/

        );
        return $this->render('orders/index.html.twig', [
            'orders' => $show,
        ]);

    }

    /**
     * @Route("/orders/orderbyStatusConfirmed", name="orderbyStatusConfirmed")
     */

    public function orderbyStatusConfirmed(PaginatorInterface $paginator,Request $request)
    {
        $orders = $this->getDoctrine()
            ->getManager()
            ->createQuery('SELECT e FROM App\Entity\Orders e WHERE e.status = :status and  e.iduser = :iduser'
            )->setParameter('status', "Confirmed")
            ->setParameter('iduser',$this->getUser())

            ->getResult();

        $show = $paginator->paginate(
            $orders,
            $request->query->get('page', 1)/*le numéro de la page à afficher*/,
            6/*nbre d'éléments par page*/

        );
        return $this->render('orders/index.html.twig', [
            'orders' => $show,
        ]);

    }

    /**
     * @Route("/orders/orderbyStatusCancelled", name="orderbyStatusCancelled")
     */

    public function orderbyStatusCancelled(PaginatorInterface $paginator,Request $request)
    {
        $orders = $this->getDoctrine()
            ->getManager()
            ->createQuery('SELECT e FROM App\Entity\Orders e WHERE e.status = :status  and  e.iduser = :iduser'
            )->setParameter('status', "Cancelled")
            ->setParameter('iduser',$this->getUser())

            ->getResult();


        $show = $paginator->paginate(
            $orders,
            $request->query->get('page', 1)/*le numéro de la page à afficher*/,
            6/*nbre d'éléments par page*/

        );
        return $this->render('orders/index.html.twig', [
            'orders' => $show,
        ]);

    }

    /**
     * @Route("/orders/statusStats", name="statusStats")
     */
    public function statusStats()
    {
        $repository = $this->getDoctrine()->getRepository(Orders::class);
        $ListOrders = $repository->findAll();
        $em = $this->getDoctrine()->getManager();

        $pending = 0;
        $confirmed = 0;
        $cancelled = 0;


        foreach ($ListOrders as $Orders) {
            if ($Orders->getStatus() == "Pending")

                $pending += 1;
            else if ($Orders->getStatus() == "Confirmed")
                $confirmed += 1;
            else
                $cancelled += 1;
        }


        $pieChart = new PieChart();
        $pieChart->getData()->setArrayToDataTable(
            [['status', 'nombres'],
                ['Pending', $pending],
                ['Confirmed', $confirmed],
                ['Cancelled', $cancelled]
            ]
        );
        $pieChart->getOptions()->setTitle('status Statistique');
        $pieChart->getOptions()->setHeight(500);
        $pieChart->getOptions()->setWidth(900);
        $pieChart->getOptions()->getTitleTextStyle()->setBold(true);
        $pieChart->getOptions()->getTitleTextStyle()->setColor('#009900');
        $pieChart->getOptions()->getTitleTextStyle()->setItalic(true);
        $pieChart->getOptions()->getTitleTextStyle()->setFontName('Arial');
        $pieChart->getOptions()->getTitleTextStyle()->setFontSize(20);

        return $this->render('orders/stats.html.twig', array('piechart' => $pieChart));
    }

    /**
     * @Route("/orders/searchOrderx ", name="searchOrderx")
     */
    public function searchOrderx(Request $request, NormalizerInterface $Normalizer)
    {
        $requestString = $request->get('searchValue');
        $orders = $this->getDoctrine()
            ->getManager()
            ->createQuery('SELECT e FROM App\Entity\Orders e WHERE e.innonumber like :innonumber  '
            )->setParameter('innonumber', $requestString)
            ->getResult();
        $jsonContent = $Normalizer->normalize($orders, 'json', ['groups' => 'orders:read']);
        $retour = json_encode($jsonContent);
        return new Response($retour);


    }
    /**
     * @Route("/orders/orderbyDueAmountback", name="orderbyDueAmountback")
     */

    public function orderbyDueAmountback(PaginatorInterface $paginator,Request $request)
    {
        $orders = $this->getDoctrine()
            ->getManager()
            ->createQuery('SELECT e FROM App\Entity\Orders e order by  e.dueamount desc')
            ->getResult();

        $show = $paginator->paginate(
            $orders,
            $request->query->get('page', 1)/*le numéro de la page à afficher*/,
            6/*nbre d'éléments par page*/

        );
        return $this->render('orders/indexBack.html.twig', [
            'orders' => $show,
        ]);

    }

    /**
     * @Route("/orders/orderbyStatusPendingback", name="orderbyStatusPendingback")
     */

    public function orderbyStatusPendingback(PaginatorInterface $paginator,Request $request)
    {
        $orders = $this->getDoctrine()
            ->getManager()
            ->createQuery('SELECT e FROM App\Entity\Orders e WHERE e.status = :status'
            )->setParameter('status', "Pending")
            ->getResult();

        $show = $paginator->paginate(
            $orders,
            $request->query->get('page', 1)/*le numéro de la page à afficher*/,
            6/*nbre d'éléments par page*/

        );
        return $this->render('orders/indexBack.html.twig', [
            'orders' => $show,
        ]);

    }

    /**
     * @Route("/orders/orderbyStatusConfirmedback", name="orderbyStatusConfirmedback")
     */

    public function orderbyStatusConfirmedback(PaginatorInterface $paginator,Request $request)
    {
        $orders = $this->getDoctrine()
            ->getManager()
            ->createQuery('SELECT e FROM App\Entity\Orders e WHERE e.status = :status'
            )->setParameter('status', "Confirmed")
            ->getResult();

        $show = $paginator->paginate(
            $orders,
            $request->query->get('page', 1)/*le numéro de la page à afficher*/,
            6/*nbre d'éléments par page*/

        );
        return $this->render('orders/indexBack.html.twig', [
            'orders' => $show,
        ]);

    }

    /**
     * @Route("/orders/orderbyStatusCancelledback", name="orderbyStatusCancelledback")
     */

    public function orderbyStatusCancelledback(PaginatorInterface $paginator,Request $request)
    {
        $orders = $this->getDoctrine()
            ->getManager()
            ->createQuery('SELECT e FROM App\Entity\Orders e WHERE e.status = :status'
            )->setParameter('status', "Cancelled")
            ->getResult();


        $show = $paginator->paginate(
            $orders,
            $request->query->get('page', 1)/*le numéro de la page à afficher*/,
            6/*nbre d'éléments par page*/

        );
        return $this->render('orders/indexBack.html.twig', [
            'orders' => $show,
        ]);

    }

    /**
     * @Route("/orders/statusStatsback", name="statusStatsback")
     */
    public function statusStatsback()
    {
        $repository = $this->getDoctrine()->getRepository(Orders::class);
        $ListOrders = $repository->findAll();
        $em = $this->getDoctrine()->getManager();

        $pending = 0;
        $confirmed = 0;
        $cancelled = 0;


        foreach ($ListOrders as $Orders) {
            if ($Orders->getStatus() == "Pending")

                $pending += 1;
            else if ($Orders->getStatus() == "Confirmed")
                $confirmed += 1;
            else
                $cancelled += 1;
        }


        $pieChart = new PieChart();
        $pieChart->getData()->setArrayToDataTable(
            [['status', 'nombres'],
                ['Pending', $pending],
                ['Confirmed', $confirmed],
                ['Cancelled', $cancelled]
            ]
        );
        $pieChart->getOptions()->setTitle('status Statistique');
        $pieChart->getOptions()->setHeight(500);
        $pieChart->getOptions()->setWidth(900);
        $pieChart->getOptions()->getTitleTextStyle()->setBold(true);
        $pieChart->getOptions()->getTitleTextStyle()->setColor('#009900');
        $pieChart->getOptions()->getTitleTextStyle()->setItalic(true);
        $pieChart->getOptions()->getTitleTextStyle()->setFontName('Arial');
        $pieChart->getOptions()->getTitleTextStyle()->setFontSize(20);

        return $this->render('orders/statusstats.html.twig', array('piechart' => $pieChart));
    }
    /**
     * @Route("/orders/barchart", name="barchart")
     */
    public function barchart()
    {
        $repository = $this->getDoctrine()->getRepository(PendingOrders::class);
        $ListOrders = $repository->findAll();
        $em = $this->getDoctrine()->getManager();

        $Statue_of_zelph = 0;
        $excalibur = 0;
        $despare = 0;
        $Jocande=0;
        $the_thinking_one=0;
        $adam_and_eve=0;
        $autre=0;
        foreach ($ListOrders as $Orders) {
            if ($Orders->getOeuvreid()->getNomoeuvre() == "statue of zelph")
                $Statue_of_zelph += 1;
            else if ($Orders->getOeuvreid()->getNomoeuvre() == "excalibur")
                $excalibur += 1;
            else if ($Orders->getOeuvreid()->getNomoeuvre() == "despare")
                $despare += 1;
            else if ($Orders->getOeuvreid()->getNomoeuvre() == "la Jocande")
                $Jocande += 1;
            else if ($Orders->getOeuvreid()->getNomoeuvre() == "the thinking one")
                $the_thinking_one += 1;
            else if ($Orders->getOeuvreid()->getNomoeuvre() == "adam and eve")
                $adam_and_eve += 1;
            else
                $autre += 1;

        }


        $col = new ColumnChart();
        $col->getData()->setArrayToDataTable([
            ['Artwork', 'Sales'],
            ['Statue of zelph', $Statue_of_zelph],
            ['excalibur', $excalibur],
            ['despare', $despare],
            ['la Jocande', $Jocande],
            ['the thinking one', $the_thinking_one],
            ['adam and eve', $adam_and_eve],
            ['autre', $autre]


        ]);
        $col->getOptions()->setTitle('Most bought artworks');
        $col->getOptions()->getAnnotations()->setAlwaysOutside(true);
        $col->getOptions()->getAnnotations()->getTextStyle()->setFontSize(14);
        $col->getOptions()->getAnnotations()->getTextStyle()->setColor('#000');
        $col->getOptions()->getAnnotations()->getTextStyle()->setAuraColor('none');
        $col->getOptions()->getHAxis()->setTitle('Artworks');
        $col->getOptions()->getVAxis()->setTitle('Sales');
        $col->getOptions()->setWidth(900);
        $col->getOptions()->setHeight(500);

        return $this->render('orders/statsback.html.twig', array('barchart' => $col));
    }
    /**
     * @Route("/orders/excel", name="excel")
     */
    public function excel(){
        $spreadsheet = new Spreadsheet();

        /* @var $sheet \PhpOffice\PhpSpreadsheet\Writer\Xlsx\Worksheet */
        $sheet = $spreadsheet->getActiveSheet(0);
        $sheet->setCellValue('A1', 'Hello World !');
        $sheet->setTitle("My First Worksheet");
        // Create your Office 2007 Excel (XLSX Format)
        $writer = new Xlsx($spreadsheet);

        $sheet->setCellValue('A1', 'Innonumber');
        $sheet->setCellValue('B1', 'DueAmount');
        $sheet->setCellValue('C1', 'Order Date ');
        $sheet->setCellValue('D1', 'User');
        $sheet->setCellValue('E1', 'Status');
        $orders =  $this->getDoctrine()
            ->getManager()
            ->createQuery('SELECT e FROM App\Entity\Orders e order by  e.orderdate desc')
            ->getResult();

        $i=0;
        foreach ($orders as $o) {
            $sheet->setCellValue('A' . $i, $o->getInnonumber());
            $sheet->setCellValue('B' . $i, $o->getDueamount());
            $sheet->setCellValue('C' . $i, $o->getOrderdate());
            $sheet->setCellValue('D' . $i, $o->getIduser());
            $sheet->setCellValue('E' . $i, $o->getStatus());
            $i++;
        }
        // Create a Temporary file in the system
        $fileName = 'Orders.xlsx';
        $temp_file = tempnam(sys_get_temp_dir(), $fileName);

        // Create the excel file in the tmp directory of the system
        $writer->save($temp_file);

        // Return the excel file as an attachment
        return $this->file($temp_file, $fileName, ResponseHeaderBag::DISPOSITION_INLINE);
    }

}
