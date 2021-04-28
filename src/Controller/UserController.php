<?php

namespace App\Controller;
use App\Controller\NotificationController;
use App\Entity\User;
use App\Form\NotificationType;
use App\Form\User1Type;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Ob\HighchartsBundle\Highcharts\Highchart;


/**
 * @Route("/user")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/", name="user_index", methods={"GET"})
     */
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('user/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="user_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $user = new User();
        $form = $this->createForm(User1Type::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('user_index');
        }

        return $this->render('user/new.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="user_show", methods={"GET"})
     */
    public function show(User $user): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="user_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, User $user): Response
    {
        $form = $this->createForm(User1Type::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_index');
        }

        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/User/{id}/edit_type", name="user_edit_type", methods={"GET","POST"})
     */
    public function editType(Request $request, User $user): Response
    {
       $user->setRoles((array)"ROLE_ARTISTE");


            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_index');



    }
    /**
     * @Route("/{id}", name="user_delete", methods={"POST"})
     */
    public function delete(Request $request, User $user): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('user_index');
    }
    /**
     * @Route("/user/statistique", name="user_stat")
     */
    public function statistique(){
        $repository = $this->getDoctrine()->getRepository(User::class);
        $ListUsers = $repository->findAll();
        $doc = $this->getDoctrine()->getManager();
        $homme = 0;
        $femme = 0;
        foreach ($ListUsers as $user) {
            if ($user->getSexe() == "Homme")

                $homme += 1;

            else
                $femme += 1;
        }
        $data = [
            ['Homme', ($homme/($homme+$femme)*100)],
            ['Femme', ($femme/($homme+$femme)*100)],
        ];

        $ob = new Highchart();
        $ob->chart->renderTo('container');
        $ob->chart->type('pie');
        $ob->title->text('statistique utilisteurs');
        $ob->series(array(array("data"=>$data)));

        return $this->render('statistique.html.twig', [
            'mypiechart' => $ob
        ]);
    }
    /**
     * @Route("/user/calendar", name="calendar", methods={"GET"})
     */
    public function calendar(): Response
    {
        return $this->render('calendar.html.twig');
    }
}
