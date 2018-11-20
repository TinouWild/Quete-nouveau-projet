<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Category;
use App\Form\ArticleSearchType;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
use App\Service\Slugify;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends AbstractController
{

    /**
     * Show all row from article's entity
     *
     * @Route("/", name="blog_index")
     * @return Response A response instance
     */
    public function index(Request $request, ObjectManager $manager, Slugify $slugify) : Response
    {
        $articles = $this->getDoctrine()
            ->getRepository(Article::class)
            ->findAll();

        if (!$articles) {
            throw $this->createNotFoundException(
                'No article found in article\'s table.'
            );
        }

        $form = $this->createForm(ArticleSearchType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $data = $form->getData();

            $article = $this->getDoctrine()
                ->getRepository(Article::class)
                ->findBy(
                    array('title' => $data['searchField'])
                );

            return $this->redirectToRoute('article_show', ['title' => $data['searchField']]);
                }

        $articleNew = new Article();
//        $slug = $slugify->generate($articleNew->getTitle());
//        $articleNew->setSlug($slug);
        $formAdd = $this->createForm(ArticleType::class, $articleNew);
        $formAdd->handleRequest($request);

        if ($formAdd->isSubmitted()) {

            $manager->persist($articleNew);
            $manager->flush();

            return $this->redirectToRoute('blog_index');
        }


        return $this->render(
            'blog/index.html.twig', [
                'articles' => $articles,
                'form' => $form->createView(),
                'formAdd' => $formAdd->createView()
            ]
        );
    }

    /**
     * @Route("/article/{title}", name="article_show")
     */
    public function showOne(Article $article) :Response
    {
        return $this->render('blog/article.html.twig', ['articles' => $article]);
    }


    /**
     * Getting a article with a formatted slug for title
     *
     * @param string $slug The slugger
     *
     * @Route("/index/{slug<^[a-z0-9-]+$>}",
     *     defaults={"slug" = null},
     *     name="blog_show")
     *  @return Response A response instance
     */
    public function show($slug) : Response
    {
        if (!$slug) {
            throw $this
                ->createNotFoundException('No slug has been sent to find an article in article\'s table.');
        }

        $slug = preg_replace(
            '/-/',
            ' ', ucwords(trim(strip_tags($slug)), "-")
        );

        $article = $this->getDoctrine()
            ->getRepository(Article::class)
            ->findOneBy(['title' => mb_strtolower($slug)]);

        if (!$article) {
            throw $this->createNotFoundException(
                'No article with '.$slug.' title, found in article\'s table.'
            );
        }

        return $this->render(
            'blog/slug.html.twig',
            [
                'article' => $article, 'slug' => $slug
            ]
        );
    }

    /**
     * @Route("/category/{name}", name="blog_show_category")
     */
    public function showByCategory(Category $category)
    {
        if (!$category) {
            throw $this
                ->createNotFoundException('No slug has been sent to find an article in article\'s table.');
        }
        $articles = $this->getDoctrine()
            ->getRepository(Article::class)
            ->findBy(
                array('category' => $category), array('id' => 'desc'), 3);

        $categorie = $this->getDoctrine()
            ->getRepository(Category::class)
            ->find($category);

        return $this->render('blog/category.html.twig', [
            'articles' => $articles, 'categorie' => $categorie
        ]);
    }
}
