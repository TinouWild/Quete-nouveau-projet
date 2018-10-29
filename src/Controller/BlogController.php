<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends AbstractController
{
    /**
     * @Route("/blog/{page}", requirements={"page"="\d+"}, name="blog_index")
     */
    public function index($page)
    {
        return $this->render('blog/index.html.twig', [
            'page' => $page,
        ]);
    }

    /**
     * @Route("/blog/{slug}", name="blog_show", requirements={"slug"="[0-9a-z-]+"})
     */
    public function show($slug = "Article Sans Titre")
    {
        $slug = str_replace (  "-" , " ", $slug);
        $slug = ucwords($slug);
        return $this->render('blog/index.html.twig', [
            'slug' => $slug,
        ]);
    }
}
