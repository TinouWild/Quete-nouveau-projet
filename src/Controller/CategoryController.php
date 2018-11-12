<?php

namespace App\Controller;

use App\Entity\Category;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    /**
     * @Route("/categorie/{id}", name="category")
     */
    public function show(Category $category) : Response
    {
        $categories = $this->getDoctrine()->getRepository(Category::class)->find($category);
        return $this->render('category/index.html.twig', [
            'categories' => $categories
        ]);
    }
}
