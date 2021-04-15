<?php


namespace App\Controller;

use App\Entity\Orders;
use App\Repository\OrdersRepository;
use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class indexController extends AbstractController{


    /**
     * @return Response
     * @Route("/",name="home")
     */
    public function index()
    {
        return $this->render('index.html.twig');
    }

}