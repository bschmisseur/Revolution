<?php

class Product
{
    private $idNum;
    private $shoeName;
    private $brand;
    private $price;
    private $style;
    private $picutre;
    private $sizes;
    
    function __construct($idNum, $shoeName, $brand, $price, $style, $picutre, $sizes)
    {
        $this->idNum = $idNum;
        $this->shoeName = $shoeName;
        $this->brand = $brand;
        $this->price = $price;
        $this->style = $style;
        $this->picutre = $picutre;
        $this->sizes = $sizes;
    }
    
    public function getIdNum()
    {
        return $this->idNum;
    }
    
    public function getShoeName()
    {
        return $this->shoeName;
    }
    
    public function getBrand()
    {
        return $this->brand;
    }
    
    public function getPrice()
    {
        return $this->price;
    }
    
    public function getStyle()
    {
        return $this->style;
    }
    
    public function getPicutre()
    {
        return $this->picutre;
    }
    
    public function getSizes()
    {
        return $this->sizes;
    }
    
    public function setIdNum($idNum)
    {
        $this->idNum = $idNum;
    }
    
    public function setShoeName($shoeName)
    {
        $this->shoeName = $shoeName;
    }
    
    public function setBrand($brand)
    {
        $this->brand = $brand;
    }
    
    public function setPrice($price)
    {
        $this->price = $price;
    }
    
    public function setStyle($style)
    {
        $this->style = $style;
    }
    
    public function setPicutre($picutre)
    {
        $this->picutre = $picutre;
    }
    
    public function setSizes($sizes)
    {
        $this->sizes = $sizes;
    }
}