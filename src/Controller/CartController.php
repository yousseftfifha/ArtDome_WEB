<?php

namespace App\Controller;

use App\Entity\Cart;
use App\Entity\Exposition;
use App\Entity\Oeuvre;
use App\Entity\User;
use App\Form\CartType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/cart")
 */
class CartController extends AbstractController
{
    /**
     * @Route("/", name="cart_index", methods={"GET"})
     */
    public function index(): Response
    {
        $carts = $this->getDoctrine()
            ->getRepository(Cart::class)
            ->findAll();

        return $this->render('cart/index.html.twig', [
            'carts' => $carts,
        ]);
    }

    /**
     * @Route("/new/{idOeuvre}", name="cart_new", methods={"GET","POST"})
     */
    public function new(Request $request, Oeuvre $id): Response
    {
        $cart = new Cart();

        $entityManager = $this->getDoctrine()->getManager();
        $d=new \DateTime("2000-02-24");
        $u=new User(0,"tfifha","youssef",$d,"ezzahra","youssef.tfifha@esprit.tn",20245989,null,"user","ww") ;
        $cart->setIdUser($u);
        $cart->setQuantity(1);


        $product = $this->getDoctrine()
            ->getRepository(Oeuvre::class)
            ->find($id);

        if (!$product) {
            throw $this->createNotFoundException(
                'No product found for id '
            );
        }
//        $query = $entityManager->createQuery('SELECT u.nom FROM App\Entity\User u ');
//        $users = $query->getResult(); // array of CmsUser username and name values
//        echo $users[0]['nom'];
        $cart->setOeuvreid($product);
        $entityManager->merge($cart);
        $entityManager->flush();

        return $this->redirectToRoute('cart_index');
    }



    /**
     * @Route("/{idcart}", name="cart_show", methods={"GET"})
     */
    public function show(Cart $cart): Response
    {
        return $this->render('cart/show.html.twig', [
            'cart' => $cart,
        ]);
    }

    /**
     * @Route("/{idcart}/edit", name="cart_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Cart $cart): Response
    {
        $form = $this->createForm(CartType::class, $cart);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('cart_index');
        }

        return $this->render('cart/edit.html.twig', [
            'cart' => $cart,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete", name="cart_delete", methods={"POST"})
     */
    public function delete(Request $request, Cart $cart): Response
    {
        if ($this->isCsrfTokenValid('delete'.$cart->getIdcart(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($cart);
            $entityManager->flush();
        }


        return $this->redirectToRoute('cart_index');
    }
}
