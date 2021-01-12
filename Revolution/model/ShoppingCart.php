<?php

class ShoppingCart
{
    private $products;
    private $totalPrice;
    
    function __construct() {
        $this->products = array(array());
        $this->totalPrice = 0;
    }
    
    public function addProduct(int $productID, float $size, int $quantity, float $price)
    {
        $inCart = false;
        $cartIndex = 0;
        
        for($i = 1; $i < count($this->products); $i++)
        {
            if($this->products[$i][0] == $productID && $this->products[$i][1] == $size)
            {
                $inCart = true;
                $cartIndex = $i;
            }
        }
        
        if(!$inCart)
        {
            $index = count($this->products);
            
            $this->products[$index][0] = $productID;
            $this->products[$index][1] = $size;
            $this->products[$index][2] = $quantity;
            $this->products[$index][3] = $price;
        }
        
        else
        {
            $this->products[$cartIndex][2]++;
        }
            
        $this->updatePrice();
    }
    
    public function changeQuantity(int $cartIndex, int $quantity)
    {
        if($quantity > 0)
        {
            $this->products[$cartIndex][2] = $quantity; 
        }
        
        else
        {
            $this->removeElement($cartIndex);
        }
        
        $this->updatePrice(); 
    }
    
    public function updatePrice()
    {
        $totalPrice = 0;
        
        for($i = 1; $i < count($this->products); $i++)
        {
            $currentPrice = $this->products[$i][3];
            $currentQuantity = $this->products[$i][2];
            
            $totalPrice += ($currentPrice * $currentQuantity);
        }
        
        $this->totalPrice = $totalPrice;
    }
    
    public function removeElement(int $cartIndex)
    {
        $shoeList = array(array());
        
        for($i = 1; $i < count($this->getProducts()); $i++)
        {
            if($i < $cartIndex)
            {
                $shoeList[$i][0] = $this->getProducts()[$i][0];
                $shoeList[$i][1] = $this->getProducts()[$i][1];
                $shoeList[$i][2] = $this->getProducts()[$i][2];
                $shoeList[$i][3] = $this->getProducts()[$i][3];
            }
            
            else 
            {
                $shoeList[$i - 1][0] = $this->getProducts()[$i][0];
                $shoeList[$i - 1][1] = $this->getProducts()[$i][1];
                $shoeList[$i - 1][2] = $this->getProducts()[$i][2];
                $shoeList[$i - 1][3] = $this->getProducts()[$i][3];
            }
        }
        
        $this->products = $shoeList;
        $this->updatePrice();
    }
    
    public function getProducts()
    {
        return $this->products;
    }
    
    public function getTotalPrice()
    {
        return $this->totalPrice;
    }
    
    public function setProducts($products)
    {
        $this->shoes = $products;
    }
    
    public function setTotalPrice(int $totalPrice)
    {
        $this->totalPrice = $totalPrice;
    }
}