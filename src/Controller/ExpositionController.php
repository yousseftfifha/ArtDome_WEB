<?php

namespace App\Controller;

use App\Entity\Exposition;
use App\Entity\Oeuvre;
use App\Entity\ReservationExpo;
use App\Entity\User;
use App\Entity\Endroit;
use App\Form\ExpositionType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\PieChart;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

/**
 * @Route("/exposition")
 */
class ExpositionController extends AbstractController
{
    /**
     * @Route("/", name="exposition_index", methods={"GET"})
     */
    public function index(PaginatorInterface $paginator, Request $request): Response
    {
      /*  $expositions = $this->getDoctrine()
            ->getManager()
            ->createQuery('SELECT e FROM App\Entity\Exposition e order by  e.dateExpo desc')
            ->getResult();*/

        $expositionRepository = $this->getDoctrine()
            ->getManager()
            ->getRepository(Exposition::class);

        $expositions = $paginator->paginate(
            $expositionRepository->findAll(),
            $request->query->get('page', 1)/*le numéro de la page à afficher*/,
            3/*nbre d'éléments par page*/

        );

        return $this->render('exposition/index.html.twig', [
            'expositions' => $expositions,

        ]);
    }

    /**
     * @Route("/back", name="exposition_indexBack", methods={"GET"})
     */
    public function indexBack(): Response
    {
        $ExpositionRepository = $this->getDoctrine()
            ->getManager()
            ->getRepository(Exposition::class);
        $expositions = $ExpositionRepository->SortExpo();

        return $this->render('exposition/indexBack.html.twig', [
            'expositions' => $expositions,
        ]);
    }

    /**
     * @Route("/new", name="exposition_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $exposition = new Exposition();
        $form = $this->createForm(ExpositionType::class, $exposition);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid() ) {
            if($exposition->getDateExpo()>new \DateTime('now')) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($exposition);
            $entityManager->flush();

            return $this->redirectToRoute('exposition_index');
        }
            else

                $this->addFlash('success', 'Ooops it seems like you wrote a previous date');
        }

        return $this->render('exposition/new.html.twig', [
            'exposition' => $exposition,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/newBack", name="exposition_newBack", methods={"GET","POST"})
     */
    public function newBack(Request $request): Response
    {
        $exposition = new Exposition();
        $form = $this->createForm(ExpositionType::class, $exposition);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid() ) {
            if($exposition->getDateExpo()>new \DateTime('now')) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($exposition);
            $entityManager->flush();

            return $this->redirectToRoute('exposition_indexBack');
        }
            else

                $this->addFlash('success', 'Ooops it seems like you wrote a previous date');
        }

        return $this->render('exposition/newBack.html.twig', [
            'exposition' => $exposition,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/Oeuvre/{codeExpo}", name="exposition_show", methods={"GET"})
     */
    public function show(Exposition $exposition,PaginatorInterface $paginator, Request $request): Response
    {
        $oeuvre = $this->getDoctrine()
            ->getManager()
            ->createQuery('SELECT o.idOeuvre,o.nomoeuvre,o.prixoeuvre,o.nomcat,o.imageoeuvre FROM App\Entity\Oeuvre o where o.codeExposition=:codeExpo')
            ->setParameter('codeExpo',$exposition->getCodeExpo())

            ->getResult();
        $artworks = $paginator->paginate(
            $oeuvre,
            $request->query->get('page', 1)/*le numéro de la page à afficher*/,
            3/*nbre d'éléments par page*/

        );
        return $this->render('exposition/show.html.twig', [
            'exposition' => $exposition,
            'oeuvres'=>$artworks
        ]);
    }








    /**
     * @Route("/{codeExpo}/back", name="exposition_showBack", methods={"GET"})
     */
    public function showBack(Exposition $exposition): Response
    {
        return $this->render('exposition/showBack.html.twig', [
            'exposition' => $exposition,
        ]);
    }

    /**
     * @Route("/{codeExpo}/edit", name="exposition_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Exposition $exposition): Response
    {
        $form = $this->createForm(ExpositionType::class, $exposition);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid() && $exposition->getDateExpo()>new \DateTime('now')) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('exposition_index');
        }

        return $this->render('exposition/edit.html.twig', [
            'exposition' => $exposition,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{codeExpo}/editBack", name="exposition_editBack", methods={"GET","POST"})
     */
    public function editBack(Request $request, Exposition $exposition): Response
    {
        $form = $this->createForm(ExpositionType::class, $exposition);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid() && $exposition->getDateExpo()>new \DateTime('now') ) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('exposition_indexBack');
        }

        return $this->render('exposition/editBack.html.twig', [
            'exposition' => $exposition,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{codeExpo}", name="exposition_delete", methods={"POST"})
     */
    public function delete(Request $request, Exposition $exposition): Response
    {
        if ($this->isCsrfTokenValid('delete'.$exposition->getCodeExpo(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($exposition);
            $entityManager->flush();
        }

        return $this->redirectToRoute('exposition_index');
    }

    /**
     * @Route("/{codeExpo}/back", name="exposition_deleteBack", methods={"POST"})
     */
    public function deleteBack(Request $request, Exposition $exposition): Response
    {
        if ($this->isCsrfTokenValid('delete'.$exposition->getCodeExpo(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($exposition);
            $entityManager->flush();
        }

        return $this->redirectToRoute('exposition_indexBack');
    }


    /**
     * @Route("/back/stats", name="exposition_stats")
     */
    public function StateStats()
    {
        $repository = $this->getDoctrine()->getRepository(Exposition::class);
        $ListExpo = $repository->findAll();
        $em = $this->getDoctrine()->getManager();

        $photos = 0;
        $tableaux = 0;
        $scultures =0;
        $céramiques =0;
        $peintures_et_céramiques=0;
        $peintures_et_tableaux =0;


        foreach ($ListExpo as $Expo) {
            if ($Expo->getThemeExpo() == "photos")

                $photos += 1;
            elseif($Expo->getThemeExpo() == "tableaux")
             $tableaux += 1;
            elseif($Expo->getThemeExpo() == "scultures")
            $scultures += 1;
            elseif($Expo->getThemeExpo() == "céramiques")
            $céramiques +=1;
            elseif($Expo->getThemeExpo() == "peintures et céramiques")
                $peintures_et_céramiques +=1;
            else
                $peintures_et_tableaux +=1;
        }


        $pieChart = new PieChart();
        $pieChart->getData()->setArrayToDataTable(
            [['State', 'nombres'],
                ['photos', $photos],
                ['tableaux', $tableaux],
                ['scultures', $scultures],
                ['céramiques', $céramiques],
                ['peintures et céramiques', $peintures_et_céramiques],
                ['peintures et tableaux', $peintures_et_tableaux]
            ]
        );
        //$pieChart->getOptions()->setTitle('Events Statistic');
        $pieChart->getOptions()->setHeight(500);
        $pieChart->getOptions()->setWidth(900);
        $pieChart->getOptions()->getTitleTextStyle()->setBold(true);
        $pieChart->getOptions()->getTitleTextStyle()->setColor('#009900');
        $pieChart->getOptions()->getTitleTextStyle()->setItalic(true);
        $pieChart->getOptions()->getTitleTextStyle()->setFontName('Arial');
        $pieChart->getOptions()->getTitleTextStyle()->setFontSize(20);

        return $this->render('exposition/stats.html.twig', array('piechart' => $pieChart));
    }

    /**
     * @Route("//search", name="exposition_searchExposition")
     */
    public function searchExpoBack(Request $request, NormalizerInterface $Normalizer)
    {
        $repository = $this->getDoctrine()->getRepository(Exposition::class);
        $requestString= $request->get('searchValue');
        $reservations = $repository->findexpoByCode($requestString);
        $jsonContent = $Normalizer->normalize($reservations, 'json',['groups'=>'expositions:read']);
        $retour=json_encode($jsonContent);
        return new Response($retour);




    }
}
