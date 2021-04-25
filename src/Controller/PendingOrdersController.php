<?php

namespace App\Controller;

use App\Entity\Oeuvre;
use App\Entity\PendingOrders;
use App\Entity\User;
use App\Form\PendingOrders1Type;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/pending/orders")
 */
class PendingOrdersController extends AbstractController
{
    /**
     * @Route("/{innonumber}", name="pending_orders_index", methods={"GET"})
     */
    public function index(int $innonumber): Response
    {

        $entityManager = $this->getDoctrine()->getManager();

        $query = $entityManager->createQuery(
            'SELECT p
    FROM App\Entity\PendingOrders p
    WHERE p.innonumber = :innonumber'
        )->setParameter('innonumber',$innonumber);

        $pendingOrders = $query->getResult();
        return $this->render('pending_orders/index.html.twig', [
            'pending_orders' => $pendingOrders,
        ]);
    }

    /**
     * @Route("/new", name="pending_orders_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $pendingOrder = new PendingOrders();


            $entityManager = $this->getDoctrine()->getManager();
        $d=new \DateTime("2000-02-24");
        $u=$this->getUser();
        $pendingOrder->setIduser($u);
        $query = $entityManager->createQuery('SELECT u FROM App\Entity\Cart u ');

        $y=rand(1000000,9999999);
        $PANIER = $query->getResult(); // array of CmsUser username and name values
        foreach ($PANIER as $p){
            $product = $this->getDoctrine()
                ->getRepository(Oeuvre::class)
                ->find($p->getOeuvreid());
            echo $p->getOeuvreid();
            $pendingOrder->setOeuvreid($product);
            $pendingOrder->setQuantity($p->getQuantity());


            $pendingOrder->setInnonumber($y);
            $entityManager->merge($pendingOrder);
            $entityManager->flush();
        }
        $q = $entityManager->createQuery('delete from App\Entity\Cart' );
        $numDeleted = $q->execute();


            return $this->redirectToRoute('orders_new',array(
                'innonumber' => $y,
            ));

    }

    /**
     * @Route("/{innonumber}", name="pending_orders_show", methods={"GET"})
     */
    public function show(PendingOrders $pendingOrder): Response
    {
        return $this->render('pending_orders/show.html.twig', [
            'pending_order' => $pendingOrder,
        ]);
    }

    /**
     * @Route("/{idPendingorder}/edit", name="pending_orders_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, PendingOrders $pendingOrder): Response
    {
        $form = $this->createForm(PendingOrders1Type::class, $pendingOrder);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('pending_orders_index');
        }

        return $this->render('pending_orders/edit.html.twig', [
            'pending_order' => $pendingOrder,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idPendingorder}", name="pending_orders_delete", methods={"POST"})
     */
    public function delete(Request $request, PendingOrders $pendingOrder): Response
    {
        if ($this->isCsrfTokenValid('delete'.$pendingOrder->getIdPendingorder(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($pendingOrder);
            $entityManager->flush();
        }

        return $this->redirectToRoute('pending_orders_index');
    }

}
