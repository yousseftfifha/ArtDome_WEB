<?php

namespace App\Controller;

use App\Entity\commentaire;
use App\Entity\Blog;
use App\Form\CommentaireType;
use Doctrine\Bundle\FixturesBundle\Tests\Fixtures\FooBundle\DataFixtures\RequiredConstructorArgsFixtures;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Routing\Annotation\Route;
use App\Uploader\UploaderInterface;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Class BlogController
 * @package App\Controller
 */
class BlogController extends AbstractController
{
    /**
     * @Route("/blog", name="index")
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {
        $limit = $request->get("limit", 10);
        $page = $request->get("page", 1);

        /** @var Paginator $blogs */
        $blogs = $this->getDoctrine()->getRepository(Blog::class)->getPaginatedBlogs(
            $page,
            $limit
        );

        $pages = ceil($blogs->count() / $limit);

        $range = range(
            max($page - 3, 1),
            min($page + 3, $pages)
        );

        return $this->render('blog/index.html.twig', [
            "blogs" => $blogs,
            "pages" => $pages,
            "page" => $page,
            "limit" => $limit,
            "range" => $range
        //    'controller_name' => 'BlogController',
        ]);
    }

    /**
     * @Route("/article-{idblog}", name="blog_read")
     * @param Blog $blog
     * @param Request $request
     * @return Response
     * @throws \Exception
     */
    public function read(Blog $blog, Request $request): Response
    {
        $commentaire = new Commentaire();
        $commentaire->setIdBlog($blog);

        $form = $this->createForm(CommentaireType::class, $commentaire)->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->persist($commentaire);
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute("blog_read", ["idblog" => $blog->getIdblog()]);
        }
        return $this->render("read.html.twig", [
            "blog" => $blog,
            "form" => $form->createView()
        ]);
    }



    /**
     * @Route("/publier-article", name="blog_create")
     * @param Request $request
     * @param UploaderInterface $uploader
     * @return Response
     * @throws \Exception
     */
    public function create(
        Request $request,
        UploaderInterface $uploader
    ): Response {
        $blog = new Blog();

        $form = $this->createForm(BlogType::class, $blog, [
            "validation_groups" => ["Default", "create"]
        ])->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $file */
            $file = $form->get("file")->getData();

            $blog->setImage($uploader->upload($file));

            $this->getDoctrine()->getManager()->persist($blog);
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute("blog_read", ["id" => $blog->getId()]);
        }

        return $this->render("blog/create.html.twig", [
            "form" => $form->createView()
        ]);
    }

    /**
     * @Route("/modifier-article/{idblog}", name="blog_update")
     * @param Request $request
     * @param Blog $blog
     * @param UploaderInterface $uploader
     * @return Response
     */
    public function update(
        Request $request,
        Blog $blog,
        UploaderInterface $uploader
    ): Response {
        $form = $this->createForm(BlogType::class, $blog)->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $file */
            $file = $form->get("file")->getData();

            if ($file !== null) {
                $blog->setImage($uploader->upload($file));
            }

            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute("blog_read", ["id" => $blog->getId()]);
        }

        return $this->render("blog/update.html.twig", [
            "form" => $form->createView()
        ]);
    }

}
