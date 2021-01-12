<?php
include_once 'Database.php';
include_once '../../model/Product.php';
include_once '../../model/User.php';
include_once '../../model/ShoppingCart.php';

session_start();

Class ProductDataService
{
    private $connection;
    
    function __construct()
    {
        $database = new Database();
        $this->connection = $database->getConnection();
    }
    
    public function createProduct(Product $product)
    {
        $sql_statement = "SELECT * FROM PRODUCT WHERE NAME='{$product->getShoeName()}';";
        $results = mysqli_query($this->connection, $sql_statement);
        $numOfRows = mysqli_num_rows($results);
        
        if($numOfRows == 0)
        {
            $pictureFile = addslashes(file_get_contents($product->getPicutre()));
            
            $sql_insert = "INSERT INTO `PRODUCT` (`ID`, `NAME`, `BRAND`, `PRICE`, `STYLE_NUMBER`, `PICTURE`) VALUES (NULL, '{$product->getShoeName()}', '{$product->getBrand()}', '{$product->getPrice()}', '{$product->getStyle()}', '{$pictureFile}');";
            $result = $this->connection->query($sql_insert);
            $productID = mysqli_insert_id($this->connection);
            
            $product->setIdNum($productID);
            
            for($i = 0; $i < count($product->getSizes()); $i++)
            {
                $currentSize = $product->getSizes()[$i][0];
                $currentQuantity = $product->getSizes()[$i][1];
                
                $sql_statement = "INSERT INTO `QUANTITY` (`ID`, `SIZE`, `QUANTITY`, `PRODUCT_ID`) VALUES (NULL, '$currentSize', '$currentQuantity', '$productID');";
                $this->connection->query($sql_statement);
            }
            
            $_SESSION['currentProduct'] = $product; 
        }
        
        else
        {
            $result = false;
        }
        
        return $result;
    }
    
    public function updateProduct(Product $product, int $idNum)
    {
        $sql_statment = "UPDATE PRODUCT SET NAME='{$product->getShoeName()}', BRAND='{$product->getBrand()}', PRICE='{$product->getPrice()}', STYLE_NUMBER='{$product->getStyle()}' WHERE ID='$idNum'";
        
        //delete all from QUANTITY table
        $sql_query = "DELETE FROM QUANTITY WHERE PRODUCT_ID='$idNum'";
        mysqli_query($this->connection, $sql_query);
        
        for($i = 0; $i < count($product->getSizes()); $i++)
        {
            $currentSize = $product->getSizes()[$i][0];
            $currentQuantity = $product->getSizes()[$i][1];
            
            $sql_statement = "INSERT INTO `QUANTITY` (`ID`, `SIZE`, `QUANTITY`, `PRODUCT_ID`) VALUES (NULL, '$currentSize', '$currentQuantity', '$idNum');";
            $this->connection->query($sql_statement);
        }
        
        return $this->connection->query($sql_statment);
    }
    
    public function editProduct(Product $product, int $idNum, $picture)
    {
        $pictureFile = addslashes(file_get_contents($picture));
        
        $sql_statment = "UPDATE PRODUCT SET NAME='{$product->getShoeName()}', BRAND='{$product->getBrand()}', PRICE='{$product->getPrice()}', STYLE_NUMBER='{$product->getStyle()}', PICTURE='{$pictureFile}' WHERE ID='$idNum'";
        
        //delete all from QUANTITY table
        $sql_query = "DELETE FROM QUANTITY WHERE PRODUCT_ID='$idNum'";
        mysqli_query($this->connection, $sql_query);
        
        return $this->connection->query($sql_statment);
    }
    
    public function deleteProduct($idNum)
    {
        //delete all from ODER_has_product Table
        $sql_delete = "DELETE FROM ORDER_has_PRODUCT WHERE PRODUCT_ID='$idNum'";
        mysqli_query($this->connection, $sql_delete);
        
        //delete all from QUANTITY table
        $sql_query = "SELECT * FROM QUANTITY WHERE PRODUCT_ID='$idNum'";
        $results = mysqli_query($this->connection, $sql_query);
        
        while($row = $results->fetch_assoc())
        {
            $currentID = $row['ID'];
            $sql_delete = "DELETE FROM QUANTITY WHERE ID='$currentID'";
            mysqli_query($this->connection, $sql_delete);
        }
        
        //delete from PRODUCT table
        $sql_delete = "DELETE FROM PRODUCT WHERE ID='$idNum'";
        return mysqli_query($this->connection, $sql_delete);
    }
    
    public function viewProducts()
    {
        $products = array();
        $index = 0; 
        
        $sql_query = "SELECT * FROM PRODUCT";
        $results = mysqli_query($this->connection, $sql_query);
        
        while($row = $results->fetch_assoc())
        {
            $id = $row['ID'];
            $name = $row['NAME'];
            $brand = $row['BRAND'];
            $price = $row['PRICE'];
            $style = $row['STYLE_NUMBER'];
            $picture = $row['PICTURE'];
            
            $sql_statement = "SELECT * FROM QUANTITY WHERE PRODUCT_ID='$id'";
            $resutlsInside = mysqli_query($this->connection, $sql_statement);
            
            $sizes = array(array());
            $indexInside = 0;
            
            while($row = $resutlsInside->fetch_assoc())
            {
                $sizes[$indexInside][0] = $row['SIZE'];
                $sizes[$indexInside][1] = $row['QUANTITY'];
                $indexInside++;
            }
            
            
            $currentProduct = new Product($id, $name, $brand, $price, $style, $picture, $sizes);
            
            $products[$index] = $currentProduct;
            $index++; 
        }
        
        return $products;
    }
    
    public function searchByParam($searchParam) 
    {
        $products = array();
        $index = 0;
        
        $sql_query = "SELECT * FROM PRODUCT WHERE `NAME` LIKE '%$searchParam%' OR `BRAND` LIKE '%$searchParam%'";
        $results = mysqli_query($this->connection, $sql_query);
        
        while($row = $results->fetch_assoc())
        {
            $id = $row['ID'];
            $name = $row['NAME'];
            $brand = $row['BRAND'];
            $price = $row['PRICE'];
            $style = $row['STYLE_NUMBER'];
            $picture = $row['PICTURE'];
            
            $sql_statement = "SELECT * FROM QUANTITY WHERE PRODUCT_ID='$id'";
            $resutlsInside = mysqli_query($this->connection, $sql_statement);
            
            $sizes = array(array());
            $indexInside = 0;
            
            while($row = $resutlsInside->fetch_assoc())
            {
                $sizes[$indexInside][0] = $row['SIZE'];
                $sizes[$indexInside][1] = $row['QUANTITY'];
                $indexInside++;
            }
            
            
            $currentProduct = new Product($id, $name, $brand, $price, $style, $picture, $sizes);
            
            $products[$index] = $currentProduct;
            $index++;
        }
        
        return $products;
    }
    
    public function getProductByID($id)
    {
        $sql_statement = "SELECT * FROM PRODUCT WHERE ID='{$id}';";
        $results = mysqli_query($this->connection, $sql_statement);
        $numOfRows = mysqli_num_rows($results);
        
        if($numOfRows == 1)
        {
            $row = $results->fetch_assoc();
            $name = $row['NAME'];
            $brand = $row['BRAND'];
            $price = $row['PRICE'];
            $style = $row['STYLE_NUMBER'];
            $picture = $row['PICTURE'];
            
            $sql_query = "SELECT * FROM QUANTITY WHERE PRODUCT_ID='$id'";
            $resutlsInside = mysqli_query($this->connection, $sql_query);
            
            $sizes = array(array());
            $indexInside = 0;
            
            while($rowInside = $resutlsInside->fetch_assoc())
            {
                $sizes[$indexInside][0] = $rowInside['SIZE'];
                $sizes[$indexInside][1] = $rowInside['QUANTITY'];
                $indexInside++;
            }
            
            $currentProduct = new Product($id, $name, $brand, $price, $style, $picture, $sizes);
            
            return $currentProduct;
        }
        
        else
        {
            return NULL;
        }
    }
    
    public function completeTransaction($address, $cardNumber, $orderNumber)
    {
        $this->connection->autocommit(false);
        $this->connection->begin_transaction();
        $transactionComplete = false;
        $updatedNum = true;
        $addedOrder = true;
        $currentCart = $_SESSION['currentCart'];
        $currentUser = $_SESSION['currentUser'];
        $currentUserID = $currentUser->getIdNum();
        $purchasedProducts = $currentCart->getProducts();
        $totalPrice = $currentCart->getTotalPrice();
        $currentDate = date("Y-m-d");
        
        //Update Product Quantities
        for($i = 1; $i < count($purchasedProducts); $i++)
        {
            $curretProduct = $this->getProductByID($purchasedProducts[$i][0]);
            $currentSize = $purchasedProducts[$i][1];
            $quantityPurchased = $purchasedProducts[$i][2];
            $sizeArray = $curretProduct->getSizes();
            
            for($j = 0; $j < count($sizeArray); $j++)
            {
                if($currentSize == $sizeArray[$j][0])
                {
                    $sizeArray[$j][1]-= $quantityPurchased;
                    break;
                }
            }
            
            $curretProduct->setSizes($sizeArray);
            if(!$this->updateProduct($curretProduct, $curretProduct->getIdNum()))
            {
                $updatedNum = false;
            }
            
        }
        
        //Create Product taking in order number, address, cardnumber, userid, totalprice
        $sqlStatment = "INSERT INTO `ORDER` (`ID`, `CONFIRMATION_NUMBER`, `ADRESS`, `CARD_NUMBER`, `USER_ID`, `TOTAL_PRICE`, `DATE`) VALUES (NULL, '$orderNumber', '$address', '$cardNumber', '$currentUserID', '$totalPrice', '$currentDate');;";
        
        $addedOrder = $this->connection->query($sqlStatment);
        
        if($updatedNum && $addedOrder)
        {
            $this->connection->commit();
            $this->connection->autocommit(true);
            $transactionComplete = true;
            $_SESSION['currentOrder'] = $orderNumber;
            $orderID = 0;
            
            $sql_query = "SELECT * FROM `ORDER` WHERE `CONFIRMATION_NUMBER` = '$orderNumber'";
            $results = mysqli_query($this->connection, $sql_query);
            $row = $results->fetch_assoc();
            $orderID = $row['ID'];
            
            for($i = 1; $i < count($purchasedProducts); $i++)
            {
                $curretProductID = $purchasedProducts[$i][0];
                $currentSize = $purchasedProducts[$i][1];
                
                $sql_statement = "INSERT INTO `ORDER_has_PRODUCT` (`ORDER_ID`, `PRODUCT_ID`, `SIZE`) VALUES ('$orderID', '$curretProductID', '$currentSize');";
                $this->connection->query($sql_statement);
            }
            
        }
        
        else
        {
            $this->connection->rollback();
        }
        return $transactionComplete;
    }
}

?>
