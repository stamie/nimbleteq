<?php
require_once __DIR__.'/Product.php';
//use Product;

class Page 
{
    private float $sumOfAllUnitPricesOnThePage;
    private $allProducts;

    public function __construct() {
        $this->sumOfAllUnitPricesOnThePage = 0;
        $this->allProducts = array();
    }

    public function addProduct(Product $product){
        $this->sumOfAllUnitPricesOnThePage += $product->getUnitPrice();
        $this->allProducts[] = $product;

    }

    public function getSumOfAllUnitPricesOnThePage(){
        return $this->sumOfAllUnitPricesOnThePage;
    }
    
    public function getAllProducts() { // return array
        $returnArray = array();
        foreach ($this->allProducts as $product){
            $returnArray[] = $product->getDatasToArray();
        }
        $returnArray["total"] = $this->getSumOfAllUnitPricesOnThePage();
        return $returnArray;
    }
    public function getAllProductsToJson() { // return array
        $return = $this->getAllProducts();

        return json_encode($return);
    }

    
}

?>