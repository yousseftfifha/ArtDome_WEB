<?php
namespace App\Controller;

use App\Entity\Orders;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BackController extends AbstractController
{


    /**
     * @return Response
     * @Route("/back",name="Back")
     */
    public function index()
    {
        return $this->render('indexBack.html.twig');
    }
    /**
     * @Route("/back/orders", name="ordersback_index", methods={"GET"})
     */
    public function indexOrders(): Response
    {
        $orders = $this->getDoctrine()
            ->getRepository(Orders::class)
            ->findAll();

        return $this->render('orders/indexBack.html.twig', [
            'orders' => $orders,
        ]);
    }
    /**
     * @Route("/back/Pending/Orders/{innonumber}", name="pendingBack_orders_index", methods={"GET"})
     */
    public function indexPendingOrders(int $innonumber): Response
    {
//        $pendingOrders = $this->getDoctrine()
//            ->getRepository(PendingOrders::class)
//            ->findBy();
        $entityManager = $this->getDoctrine()->getManager();

        $query = $entityManager->createQuery(
            'SELECT p
    FROM App\Entity\PendingOrders p
    WHERE p.innonumber = :innonumber'
        )->setParameter('innonumber',$innonumber);

        $pendingOrders = $query->getResult();
        return $this->render('pending_orders/indexBack.html.twig', [
            'pending_orders' => $pendingOrders,
        ]);
    }
}