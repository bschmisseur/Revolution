<?php
include_once '../../data/ProductDataService.php';

Class ProductBusinessService
{
    private $productDataService;
    
    function __construct()
    {
        $this->productDataService = new ProductDataService();
    }
    
    public function createProduct(Product $product)
    {
        return $this->productDataService->createProduct($product);
    }
    
    public function updateProduct(Product $product)
    {
        $currentProduct = $product->getIdNum();
        return $this->productDataService->updateProduct($product, $currentProduct);
    }
    
    public function editProduct(Product $product, $picture)
    {
        return $this->productDataService->editProduct($product, $product->getIdNum(), $picture);
    }
    
    public function deleteProduct()
    {
        $currentProduct = $_SESSION['currentProduct']->getIdNum();
        return $this->productDataService->deleteProduct($currentProduct);
    }
    
    public function viewProducts()
    {
        return $this->productDataService->viewProducts();
    }
    
    public function searchProducts($searchParam)
    {
        return $this->productDataService->searchByParam($searchParam);
    }
    
    public function getProductByID($id)
    {
        return $this->productDataService->getProductByID($id);
    }
    
    public function completeTransaction($address, $cardNumber)
    {
        return $this->productDataService->completeTransaction($address, $cardNumber, $this->random_num(10));
    }
    
    private function random_num($size)
    {
        $alpha_key = '';
        $keys = range('A', 'Z');
        
        for ($i = 0; $i < 2; $i++) {
            $alpha_key .= $keys[array_rand($keys)];
        }
        
        $length = $size - 2;
        
        $key = '';
        $keys = range(0, 9);
        
        for ($i = 0; $i < $length; $i++) {
            $key .= $keys[array_rand($keys)];
        }
        
        return $alpha_key . $key;
    }
}

?>