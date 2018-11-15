<?php
/**
 * Created by PhpStorm.
 * User: etienne
 * Date: 15/11/18
 * Time: 16:50
 */

namespace App\DataFixtures;


use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    private $categories = [
        'PHP',
        'Javascript',
        'Java',
        'Ruby',
        'Quete'
    ];

    public function load(ObjectManager $manager)
    {
        foreach ($this->categories as $key => $categoryName) {
            $category = new Category();
            $category->setName($categoryName);
            $manager->persist($category);
            $this->addReference('categorie_' . $key, $category);
        }
        $manager->flush();
    }
}