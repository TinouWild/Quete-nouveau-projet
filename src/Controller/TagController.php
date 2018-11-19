<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Tag;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class TagController extends AbstractController
{
    /**
     * @Route("/tag/{name}", name="tag")
     */
    public function index(Tag $tag)
    {
        return $this->render('tag/index.html.twig', ['tag' => $tag]);
    }
}