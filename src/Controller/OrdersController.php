<?php

namespace App\Controller;

use App\Entity\Oeuvre;
use App\Entity\Orders;
use App\Entity\User;
use App\Form\Orders1Type;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
        $orders = $this->getDoctrine()
            ->getRepository(Orders::class)
            ->findAll();

        return $this->render('orders/index.html.twig', [
            'orders' => $orders,
        ]);
    }

    /**
     * @Route("/new", name="orders_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $order = new Orders();

            $entityManager = $this->getDoctrine()->getManager();
            $d=new \DateTime("2000-02-24");
            $u=new User(0,"tfifha","youssef",$d,"ezzahra","youssef.tfifha@esprit.tn",20245989,null,"user","ww") ;
            $order->setIduser($u);
            $query = $entityManager->createQuery('SELECT u FROM App\Entity\PendingOrders u ');

            $y=rand(1000000,9999999);
            $montant=0;
            $PANIER = $query->getResult(); // array of CmsUser username and name values
            foreach ($PANIER as $p){
                $product = $this->getDoctrine()
                    ->getRepository(Oeuvre::class)
                    ->find($p->getOeuvreid());
                echo $p->getOeuvreid();
            $montant+=$p->getQuantity()*$product->getPrixoeuvre();
                $order->setInnonumber($p->getInnonumber());
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
     * @Route("/{orderid}/edit", name="orders_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Orders $order): Response
    {
        $form = $this->createForm(Orders1Type::class, $order);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('orders_index');
        }

        return $this->render('orders/edit.html.twig', [
            'order' => $order,
            'form' => $form->createView(),
        ]);
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
}
