<?php

class Product 
{
    private $title;
    private $size;
    private $unit_price;
    private $description;

    function __construct($title, $size, $unit_price, $description) {
        $this->title       = $title;
        $this->size        = $size;
        $this->unit_price  = floatval($unit_price);
        $this->description = $description;
    }
    public function getTitle(){
        return $this->title;
    }
    public function getSize(){
        return $this->size;
    }
    public function getUnitPrice(){
        return $this->unit_price;
    }
    public function getDescription(){
        return $this->description;
    }

    public function getDatasToArray(){
        $array = array(
            "title"       => $this->getTitle(),
            "size"        => $this->getSize(),
            "unit_price"  => $this->getUnitPrice(),
            "description" => $this->getDescription(),
        );

        return $array;
    }
    
}

?>