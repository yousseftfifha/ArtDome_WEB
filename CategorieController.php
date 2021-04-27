<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Form\CategorieType;
use App\Repository\categorieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/categorie")
 */
class CategorieController extends AbstractController
{
    /**
     * @Route("/", name="categorie_index", methods={"GET"})
     */
    public function index(categorieRepository $repository): Response
    {
        $categories = $this->getDoctrine()
            ->getRepository(Categorie::class);
       $categories=$repository->Sortcategorie();

        return $this->render('categorie/showBack.html.twig', [
            'categories' => $categories,
            
        ]);
    }

    /**
     * @Route("/new", name="categorie_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $categorie = new Categorie();
        $form = $this->createForm(CategorieType::class, $categorie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($categorie);
            $entityManager->flush();

            return $this->redirectToRoute('categorie_index');
        }

        return $this->render('categorie/new.html.twig', [
            'categorie' => $categorie,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/show/{idCat}", name="categorie_show", methods={"GET"})
     */
    public function show(Categorie $categorie): Response
    {
        return $this->render('categorie/show.html.twig', [
            'categorie' => $categorie,
        ]);
    }

  /**
     * @Route("/{idCat}/edit", name="categorie_edit", methods={"GET","POST"})
     */
     public function edit(Request $request, Categorie $categorie): Response
   {
       $form = $this->createForm(CategorieType::class, $categorie);
       $form->handleRequest($request);

       if ($form->isSubmitted() && $form->isValid()) {
           $this->getDoctrine()->getManager()->flush();

           return $this->redirectToRoute('categorie_index');
       }

       return $this->render('categorie/edit.html.twig', [
           'categorie' => $categorie,
           'form' => $form->createView(),
       ]);
   }

   /**
    * @Route("/delete/{idCat}", name="categorie_delete", methods={"POST"})
    */
    public function delete(Request $request, Categorie $categorie): Response
    {
        if ($this->isCsrfTokenValid('delete'.$categorie->getIdCat(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($categorie);
            $entityManager->flush();
        }

        return $this->redirectToRoute('categorie_index');
    }
    /**
     * @Route("/{idCat}/editback", name="categorie_edit", methods={"GET","POST"})
     */
    public function editback(Request $request, Categorie $categorie): Response
    {
        $form = $this->createForm(CategorieType::class, $categorie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('categorie_index');
        }

        return $this->render('categorie/editback.html.twig', [
            'categorie' => $categorie,
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/newback", name="categorie_new", methods={"GET","POST"})
     */
    public function newback(Request $request): Response
    {
        $categorie = new Categorie();
        $form = $this->createForm(CategorieType::class, $categorie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($categorie);
            $entityManager->flush();

            return $this->redirectToRoute('categorie_index');
        }

        return $this->render('categorie/newback.html.twig', [
            'categorie' => $categorie,
            'form' => $form->createView(),
        ]);
    }
}
