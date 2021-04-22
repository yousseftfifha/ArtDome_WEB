<?php


namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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