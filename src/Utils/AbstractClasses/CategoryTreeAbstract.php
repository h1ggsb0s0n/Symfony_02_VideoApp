<?php 

namespace App\Utils\AbstractClasses;


use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

abstract class CategoryTreeAbstract{
    
    public $categoriesArrayFromDb;
    protected static $dbConnection; //singleton pattern -> only one DB connection
    
    public function __construct(EntityManagerInterface $entitymanager, UrlGeneratorInterface $urlgenerator){
        
        $this->entitymanager = $entitymanager;
        $this->urlgenerator = $urlgenerator;
        $this->categoriesArrayFromDb = $this->getCategories();
    }
    
    
    abstract public function getCategoryList(array $categories_array):array;
    
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