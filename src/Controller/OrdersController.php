<?php

namespace App\Controller;

use App\Entity\Oeuvre;
use App\Entity\Orders;
use App\Entity\PendingOrders;
use App\Entity\User;
use App\Form\Orders1Type;
use App\Repository\OrdersRepository;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\BarChart;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\PieChart;
use Dompdf\Dompdf;
use Dompdf\Options;
use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;
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
    public function new(Request $request, int $innonumber, \Swift_Mailer $mailer,ProviderManager $providerManager): Response
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
        $dompdf->stream("ASllOrders.pdf", [
            "Attachment" => false
        ]);
        return $this->redirectToRoute('orders_index');

    }
    /**
     * @Route("/orders/generate_pdfUser", name="generate_pdfUser")
     */
    public function generate_pdfUser(){

        $options = new Options();
        $options->set('defaultFont', 'Roboto');
        $options->setIsRemoteEnabled(true);

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
        return $this->redirectToRoute('orders_index');

    }

    /**
     * @Route("/orders/orderbyDueAmount", name="orderbyDueAmount")
     */

    public function orderbyDueAmount(PaginatorInterface $paginator,Request $request)
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
            ->createQuery('SELECT e FROM App\Entity\Orders e WHERE e.status = :status'
            )->setParameter('status', "Pending")
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
            ->createQuery('SELECT e FROM App\Entity\Orders e WHERE e.status = :status'
            )->setParameter('status', "Confirmed")
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
            ->createQuery('SELECT e FROM App\Entity\Orders e WHERE e.status = :status'
            )->setParameter('status', "Cancelled")
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

        return $this->render('orders/statsback.html.twig', array('piechart' => $pieChart));
    }
    /**
     * @Route("/orders/statusStatsback", name="statusStatsback")
     */
    public function ArtworkStats()
    {
        $repositoryPending = $this->getDoctrine()->getRepository(PendingOrders::class);
        $repositoryArtwork = $this->getDoctrine()->getRepository(Oeuvre::class);
        $ListPending = $repositoryPending->findAll();
        $ListArtwork = $repositoryArtwork->findAll();
        $em = $this->getDoctrine()->getManager();

        $pending = 0;
        $confirmed = 0;
        $cancelled = 0;


        foreach ($ListPending as $pending) {
            foreach ($ListArtwork as $art) {

                if ($pending->getOeuvreid()->getNomoeuvre()==$art->getNomoeuvre())
                    $bar = new BarChart();
                $bar->getData()->setArrayToDataTable([
                    ['Artwork', 'Popularity']
                    ['']
                ]);

            }
        }
        $bar = new BarChart();
        $bar->getData()->setArrayToDataTable([
            ['City', '2010 Population', '2000 Population'],
            ['New York City, NY', 8175000, 8008000],
            ['Los Angeles, CA', 3792000, 3694000],
            ['Chicago, IL', 2695000, 2896000],
            ['Houston, TX', 2099000, 1953000],
            ['Philadelphia, PA', 1526000, 1517000]
        ]);
        $bar->getOptions()->setTitle('Population of Largest U.S. Cities');
        $bar->getOptions()->getHAxis()->setTitle('Population of Largest U.S. Cities');
        $bar->getOptions()->getHAxis()->setMinValue(0);
        $bar->getOptions()->getVAxis()->setTitle('City');
        $bar->getOptions()->setWidth(900);
        $bar->getOptions()->setHeight(500);

        return $this->render('orders/statsback.html.twig', array('piechart' => $pieChart));
    }

}
