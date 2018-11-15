<?php
/**
 * Created by PhpStorm.
 * User: etienne
 * Date: 15/11/18
 * Time: 17:05
 */

namespace App\DataFixtures;


use App\Entity\Article;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker;

class ArticleFixtures extends Fixture implements DependentFixtureInterface {

    public function load(ObjectManager $manager)
    {
        for ($i=0; $i < 50; $i++) {
            $faker = Faker\Factory::create();
            $faker2 = Faker\Factory::create();
            $article = new Article();
            $article->setTitle(mb_strtolower($faker->name()));
            $article->setContent($faker2->sentence());

            $manager->persist($article);
            $article->setCategory($this->getReference('categorie_'.rand(0,4)));
            $manager->flush();
        }
    }

    public function getDependencies()
    {
        return [CategoryFixtures::class];
    }
}