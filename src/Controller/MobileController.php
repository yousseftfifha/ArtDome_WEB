<?php

namespace App\Controller;

use App\Entity\Event;
use App\Entity\Orders;
use App\Repository\EventRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\SerializerInterface;
use  Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Encoder\JsonEncoder;

class MobileController extends AbstractController
{
    /**
     * @Route("/mobile", name="mobile")
     */
    public function index(): Response
    {
        return $this->render('mobile/index.html.twig', [
            'controller_name' => 'MobileController',
        ]);
    }

    /**
     * @Route("/listEvent", name="listEvent")
     */
    public function getAllEvents()
    {
        $event = $this->getDoctrine()->getManager()->getRepository(Event::class)->findAll();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($event);

        return new JsonResponse($formatted);

    }

    /**
     * @Route("/addEvent", name="addEvent")
     */
    public function addEvent(Request $request, SerializerInterface $serializer, EntityManagerInterface $em):Response
    {
        $content=$request->getContent();
        $data=$serializer->deserialize($content,Event::class,'json');
        $em->persist($data);
        $em->flush();
        return new Response('Event added successfully'.json_encode($data));
    }

    /**
     * @Route("/deleteEvent/{codeEvent}", name="deleteEvent", methods={"GET"})
     */
    public function delete(Request $request)
    {

        $id = $request->get("codeEvent");

        $em = $this->getDoctrine()->getManager();
        $event = $em->getRepository(Event::class)->find($id);
        if($event!=null ) {
            $em->remove($event);
            $em->flush();

            $serialize = new Serializer([new ObjectNormalizer()]);
            $formatted = $serialize->normalize("Event deleted successfully.");
            return new JsonResponse($formatted);

        }
        return new JsonResponse("Invalid event code.");


    }
    /**
     * @Route("/{orderid}/CancelMobile", name="CancelMobile", methods={"GET","POST"})
     */
    public function CancelMobile(Request $request, Orders $order): Response
    {

        $order->setStatus("Cancelled");
        $this->getDoctrine()->getManager()->flush();
        $serialize = new Serializer([new ObjectNormalizer()]);
        $formatted = $serialize->normalize("Event deleted successfully.");
        return new JsonResponse($formatted);
    }
    /**
     * @Route("/detailEvent/{codeEvent}", name="detailEvent")
     */
    public function detailEvent(Request $request)
    {
        $id = $request->get("codeEvent");

        $em = $this->getDoctrine()->getManager();
        $event = $this->getDoctrine()->getManager()->getRepository(Event::class)->find($id);
        $encoder = new JsonEncoder();
        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object->getDescription();
        });
        $serializer = new Serializer([$normalizer], [$encoder]);
        $formatted = $serializer->normalize($event);
        return new JsonResponse($formatted);
    }
    /**
     * @Route("/showOrders/{iduser}", name="showOrders", methods={"GET"})
     */
    public function showOrders(NormalizerInterface $normalizer,int $iduser): Response
    {
        $orders = $this->getDoctrine()
            ->getManager()
            ->createQuery('SELECT e FROM App\Entity\Orders e  WHERE e.iduser = :iduser order by  e.orderdate desc')
            ->setParameter('iduser',$iduser)
            ->getResult();

        $jsonContent=$normalizer->normalize($orders,'json',['groups'=>'orders:read']);
//        return $this->render('orders/indexJSON.html.twig', [
//            'data' => $jsonContent,
//        ]);
        return new Response(json_encode($jsonContent));
    }
    /**
     * @Route("/ShowPend/{innonumber}", name="ShowPend", methods={"GET"})
     */
    public function ShowPend(NormalizerInterface $normalizer,int $innonumber): Response
    {

        $entityManager = $this->getDoctrine()->getManager();

        $query = $entityManager->createQuery(
            'SELECT p
    FROM App\Entity\PendingOrders p
    WHERE p.innonumber = :innonumber'
        )->setParameter('innonumber',$innonumber);

        $pendingOrders = $query->getResult();
        $jsonContent=$normalizer->normalize($pendingOrders,'json',['groups'=>'pendingorders:read']);
        return new Response(json_encode($jsonContent));

    }
    /**
     * @Route("/listOrders", name="listOrders")
     */
    public function getlistOrders()
    {
        $orders = $this->getDoctrine()->getManager()->getRepository(Orders::class)->findAll();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($orders);

        return new JsonResponse($formatted);

    }
}
