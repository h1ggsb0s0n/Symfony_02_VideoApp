<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Category;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $this->loadMainCategories($manager);
        

        $manager->flush();
    }
    
    private function loadMainCategories($manager){
        foreach ($this->getMainCategoriesData() as [$name]){
            
            $category = new Category();
            $category->setName($name);
            $manager->persist($category);
        }
    }
    
    private function getMainCategoriesData(){
        return [
            ['Electronics', 1],
            ['Toys', 2],
            ['Books', 3],
            ['Movies', 4],
            
        ];
    }
}
