<?php
namespace App\Controller;

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

}