<?php 

namespace App\Utils\AbstractClasses;


use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

abstract class CategoryTreeAbstract{
    
    public $categoriesArrayFromDb;
    public $categorylist;
    
    protected static $dbConnection; //singleton pattern -> only one DB connection
    
    public function __construct(EntityManagerInterface $entitymanager, UrlGeneratorInterface $urlgenerator){
        
        $this->entitymanager = $entitymanager;
        $this->urlgenerator = $urlgenerator;
        $this->categoriesArrayFromDb = $this->getCategories();
    }
    
    
    
    abstract public function getCategoryList(array $categories_array);
    
    
    public function buildTree(int $parent_id = null): array{//default value -> null
        
        $subcategory = [];
        foreach($this->categoriesArrayFromDb as $category){
            if($category['parent_id']== $parent_id){ //loop through elements with id xy
                
                $children = $this->buildTree($category['id']);
                
                if($children){//empty array is false in php
                    $category['children'] = $children;//adds new element with the index 'children'
                    
                }
                
                $subcategory[] = $category;// same as array_push($subcategory, $category);
                
            }
        }
        
        return $subcategory;
    }
    
    private function getCategories(){
        
        if(self::$dbConnection){//static variable therefor usage of self//will be created in the first instanciation
            return self::$dbConnetion;
        } else{
            $conn = $this->entitymanager->getConnection();
            $sql = "SELECT * FROM categories";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll();
        }
        
    }
    
    
}

?>