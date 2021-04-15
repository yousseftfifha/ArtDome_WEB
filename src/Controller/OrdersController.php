<?php

namespace App\Controller;

use App\Entity\Oeuvre;
use App\Entity\Orders;
use App\Entity\User;
use App\Form\Orders1Type;
use App\Repository\OrdersRepository;
use App\Services\Cart\CartService;
use Dompdf\Dompdf;
use Dompdf\Options;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * @Route("/orders")
 */
class OrdersController extends AbstractController
{
    /**
     * @Route("/", name="orders_index", methods={"GET"})
     */
    public function index(): Response
    {
        $orders =  $this->getDoctrine()
            ->getManager()
            ->createQuery('SELECT e FROM App\Entity\Orders e order by  e.orderdate desc')
            ->getResult();


        return $this->render('orders/index.html.twig', [
            'orders' => $orders,
        ]);
    }

    /**
     * @Route("/new/{innonumber}", name="orders_new", methods={"GET","POST"})
     */
    public function new(Request $request ,int $innonumber): Response
    {
        $order = new Orders();

            $entityManager = $this->getDoctrine()->getManager();
            $d=new \DateTime("2000-02-24");
            $u=new User(0,"tfifha","youssef",$d,"ezzahra","youssef.tfifha@esprit.tn",20245989,null,"user","ww") ;
            $order->setIduser($u);
            $query = $entityManager->createQuery('SELECT u FROM App\Entity\PendingOrders u WHERE u.innonumber = :innonumber'
            )->setParameter('innonumber',$innonumber);

            $y=rand(1000000,9999999);
            $montant=0;
            $PANIER = $query->getResult(); // array of CmsUser username and name values
            foreach ($PANIER as $p){
                $product = $this->getDoctrine()
                    ->getRepository(Oeuvre::class)
                    ->find($p->getOeuvreid());
            $montant+=$p->getQuantity()*$product->getPrixoeuvre();

                $order->setInnonumber($innonumber);
            }
            $datetime=new \DateTime('now');
            $order->setOrderdate($datetime);
            $order->setStatus("Pending");
            $order->setDueamount($montant);
            $entityManager->merge($order);
            $entityManager->flush();

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
        if ($this->isCsrfTokenValid('delete'.$order->getOrderid(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($order);
            $entityManager->flush();
        }

        return $this->redirectToRoute('orders_index');
    }
    /**
     * @Route("/orders/pdf", name="pdf", methods={"GET"})
     */
    public function pdf(OrdersRepository $OrdersRepository): Response
    {
        // Configure Dompdf according to your needs
        $pdfOptions = new Options();

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);
        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('orders/liste.html.twig', [
            'orders' => $OrdersRepository->findAll(),
        ]);

        // Load HTML to Dompdf
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (inline view)
        $dompdf->stream("mypdf.pdf", [
            "Attachment" => true
        ]);
        return $this->redirectToRoute('orders_index');

    }


}
