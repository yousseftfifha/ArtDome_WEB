<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Entity\Oeuvre;
use App\Form\CategorieType;
use App\Form\OeuvreType;
use App\Repository\CategorieRepository;
use App\Repository\FormationRepository;
use App\Repository\oeuvreRepository;
use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\Bridge\Google\Transport\GmailSmtpTransport;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/oeuvre")
 */
class OeuvreController extends AbstractController
{
    /**
     * @Route("/", name="oeuvre_index", methods={"GET"})
     */
    public function index(): Response
    {
        $oeuvres = $this->getDoctrine()
            ->getRepository(Oeuvre::class)
            ->findAll();

        return $this->render('oeuvre/index.html.twig', [
            'oeuvres' => $oeuvres,
        ]);
    }

    /**
     * @Route("/new", name="oeuvre_new", methods={"GET","POST"})
     */
    public function new(Request $request, \Swift_Mailer $mailer): Response
    {
        $oeuvre = new Oeuvre();
        $form = $this->createForm(OeuvreType::class, $oeuvre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($oeuvre);
            $entityManager->flush();
           //send mail
            $message = (new \Swift_Message('confirmation'))
                ->setFrom('artdomeproject@gmail.com')
                ->setTo($oeuvre->getEmailartiste())
                ->setBody(
                    "Votre article a bien été ajouté 
                          merci d'avoir choisi ARTDOME 
                          a bientot"
                         )



            ;
            $mailer->send($message);
//mail sent

            return $this->redirectToRoute('oeuvre_index');
        }

        return $this->render('oeuvre/new.html.twig', [
            'oeuvre' => $oeuvre,
            'form' => $form->createView(),
        ]);

    }

    /**
     * @Route("/show/{idOeuvre}", name="oeuvre_show", methods={"GET"})
     */
    public function show(Oeuvre $oeuvre): Response
    {
        return $this->render('oeuvre/show.html.twig', [
            'oeuvre' => $oeuvre,
        ]);
    }

    /**
     * @Route("/{idOeuvre}/edit", name="oeuvre_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Oeuvre $oeuvre , \Swift_Mailer $mailer): Response
    {
        $form = $this->createForm(OeuvreType::class, $oeuvre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $message = (new \Swift_Message('Modification'))
                ->setFrom('artdomeproject@gmail.com')
                ->setTo($oeuvre->getEmailartiste())
                ->setBody(
                    "Votre article a bien été modifié
                          merci d'avoir choisi ARTDOME 
                          a bientot"
                )
            ;
            $mailer->send($message);

            return $this->redirectToRoute('oeuvre_index');

        }

        return $this->render('oeuvre/edit.html.twig', [
            'oeuvre' => $oeuvre,
            'form' => $form->createView(),

        ]);

    }

    /**
     * @Route("/delete/{idOeuvre}", name="oeuvre_delete", methods={"POST"})
     */
    public function delete(Request $request, Oeuvre $oeuvre): Response
    {
        if ($this->isCsrfTokenValid('delete'.$oeuvre->getIdOeuvre(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($oeuvre);
            $entityManager->flush();

        }

        return $this->redirectToRoute('oeuvre_index');
    }




    /**
     * @return Response
     * @Route("/pdf",name="pdf", methods={"GET"})
     */

    public function pdf(oeuvreRepository $repform ):Response
    {
        // Configure Dompdf according to your needs
        $pdfOptions = new Options();

        $pdfOptions->set('defaultFont', 'Arial');

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);


        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('oeuvre/pdf.html.twig', [
            $oeuvres =$repform->findAll(),
            'oeuvres' => $oeuvres
        ]);

        // Load HTML to Dompdf
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (inline view)
        $dompdf->stream("oeuvres.pdf", [
            "Attachment" => true
        ]);
        return new Response('', 200, [
            'Content-Type' => 'application/pdf',
        ]);

    }

    /**
     * @Route("/searchajax ", name="ajaxsearch")
     */
    public function searchajax(Request $request)
    {
        $repository = $this->getDoctrine()->getRepository(Oeuvre::class);
        $requestString=$request->get('searchValue');
        $oeuvres = $repository->ajax($requestString);

        return $this->render('oeuvre/ajax.html.twig', [
            "oeuvres"=>$oeuvres
        ]);
    }
    /**
     * @Route("/stat", name="stat")
     */
    public function statistiques( oeuvreRepository $for){

        $oeuvres =$for->findAll();
        $categColor=[];


        //on va démonte les données pour les séparer tel qu'attends par ChartJS
        foreach ($oeuvres as $oeuvre) {

            $categColor[] = $oeuvre->getColor();

        }

            //On va chercher le nbr de formations par date

            $oeuvres =  $for->CountByDate();
            $dates = [];
            $Count = [];

            foreach ($oeuvres as $oeuvre) {

                $dates[] =$oeuvre['dateOeuvres'];
                $Count[] =$oeuvre['count'];


            }





            return $this->render('oeuvre/stats.html.twig',[

                'dates'=> json_encode($dates),
                'Count'=> json_encode($Count),
                'categColor'=> json_encode($categColor),


            ]);



    }

}
