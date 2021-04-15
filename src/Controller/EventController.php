<?php

namespace App\Controller;

use App\Entity\Event;
use App\User;
use App\Form\EventType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Gedmo\Sluggable\Util\Urlizer;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\Exception\FileException;


/**
 * @Route("/event")
 */
class EventController extends AbstractController
{
    /**
     * @Route("/", name="event_index", methods={"GET"})
     */
    public function index(): Response
    {
        $events = $this->getDoctrine()
            ->getRepository(Event::class)
            ->findAll();

        return $this->render('event/index.html.twig', [
            'events' => $events,
        ]);
    }

    /**
     * @Route("/back", name="event_indexBack", methods={"GET"})
     */
    public function indexBack(): Response
    {
        $events = $this->getDoctrine()
            ->getRepository(Event::class)
            ->findAll();

        return $this->render('event/indexBack.html.twig', [
            'events' => $events,
        ]);
    }

    /**
     * @Route("/new", name="event_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $event = new Event();
        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()&& $event->getDate()>new \DateTime('now')) {
            $file =$request->files->get('event')['image'];
            $uploads_directory=$this->getParameter('uploads_directory');
            $filename= md5(uniqid()) . '.' . $file->guessExtension();
            $file->move(
                $uploads_directory,
                $filename
            );
            $event->setImage($filename);

            $file1 =$request->files->get('event')['video'];
            $uploads_directory1=$this->getParameter('uploads_directory');
            $filename1= md5(uniqid()) . '.' . $file1->guessExtension();
            $file1->move(
                $uploads_directory1,
                $filename1
            );
            $event->setVideo($filename1);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($event);
            $entityManager->flush();

            return $this->redirectToRoute('event_index');
        }

        return $this->render('event/new.html.twig', [
            'event' => $event,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/newBack", name="event_newBack", methods={"GET","POST"})
     */
    public function newBack(Request $request): Response
    {
        $event = new Event();
        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid() && $event->getDate()>new \DateTime('now')) {
            $file =$request->files->get('event')['image'];
            $uploads_directory=$this->getParameter('uploads_directory');
            $filename= md5(uniqid()) . '.' . $file->guessExtension();
            $file->move(
                $uploads_directory,
                $filename
            );
            $event->setImage($filename);

            $file1 =$request->files->get('event')['video'];
            $uploads_directory1=$this->getParameter('uploads_directory');
            $filename1= md5(uniqid()) . '.' . $file1->guessExtension();
            $file1->move(
                $uploads_directory1,
                $filename1
            );
            $event->setVideo($filename1);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($event);
            $entityManager->flush();

            return $this->redirectToRoute('event_indexBack');
        }

        return $this->render('event/newBack.html.twig', [
            'event' => $event,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{codeEvent}", name="event_show", methods={"GET"})
     */
    public function show(Event $event): Response
    {
        return $this->render('event/show.html.twig', [
            'event' => $event,
        ]);
    }

    /**
     * @Route("/{codeEvent}/back", name="event_showBack", methods={"GET"})
     */
    public function showBack(Event $event): Response
    {
        return $this->render('event/showBack.html.twig', [
            'event' => $event,
        ]);
    }

    /**
     * @Route("/{codeEvent}/edit", name="event_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Event $event): Response
    {
        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()&& $event->getDate()>new \DateTime('now')) {
            $file =$request->files->get('event')['image'];
            $uploads_directory=$this->getParameter('uploads_directory');
            $filename= md5(uniqid()) . '.' . $file->guessExtension();
            $file->move(
                $uploads_directory,
                $filename
            );
            $event->setImage($filename);

            $file1 =$request->files->get('event')['video'];
            $uploads_directory1=$this->getParameter('uploads_directory');
            $filename1= md5(uniqid()) . '.' . $file1->guessExtension();
            $file1->move(
                $uploads_directory1,
                $filename1
            );
            $event->setVideo($filename1);

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('event_index');
        }

        return $this->render('event/edit.html.twig', [
            'event' => $event,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{codeEvent}/editBack", name="event_editBack", methods={"GET","POST"})
     */
    public function editBack(Request $request, Event $event): Response
    {
        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);
        $event->setImage($event->getImage());
        if ($form->isSubmitted() && $form->isValid()&& $event->getDate()>new \DateTime('now')) {
            $file =$request->files->get('event')['image'];
            $uploads_directory=$this->getParameter('uploads_directory');
            $filename= md5(uniqid()) . '.' . $file->guessExtension();
            $file->move(
                $uploads_directory,
                $filename
            );
            $event->setImage($filename);

            $file1 =$request->files->get('event')['video'];
            $uploads_directory1=$this->getParameter('uploads_directory');
            $filename1= md5(uniqid()) . '.' . $file1->guessExtension();
            $file1->move(
                $uploads_directory1,
                $filename1
            );
            $event->setVideo($filename1);

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('event_indexBack');
        }

        return $this->render('event/editBack.html.twig', [
            'event' => $event,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{codeEvent}/deleteBack", name="event_delete", methods={"POST"})
     */
    public function delete(Request $request, Event $event): Response
    {
        if ($this->isCsrfTokenValid('delete'.$event->getCodeEvent(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($event);
            $entityManager->flush();
        }

        return $this->redirectToRoute('event_index');
    }

    /**
     * @Route("/{codeEvent}", name="event_deleteBack", methods={"POST"})
     */
    public function deleteBack(Request $request, Event $event): Response
    {
        if ($this->isCsrfTokenValid('delete'.$event->getCodeEvent(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($event);
            $entityManager->flush();
        }

        return $this->redirectToRoute('event_indexBack');
    }

}
