<?php


namespace App\Controller;


use App\Entity\User;
use App\Form\ProfileFormType;
use App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
/**
 * @Route("/profile")
 */
class ProfileController extends AbstractController
{
    /**
     * @Route("/{id}/ProfileEdit", name="profile_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, User $user): Response
    {
        $form = $this->createForm(ProfileFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('profile_index');
        }

        return $this->render('security/ProfileEdit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }
}
