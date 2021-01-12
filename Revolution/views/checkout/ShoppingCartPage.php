<?php 
include "../../business/ProductBusinessService.php";

$service = new ProductBusinessService();
$currentCart = $_SESSION['currentCart'];

if(isset($_POST['sizeChoice']))
{
    $currentSize = $_POST['sizeChoice'];
    $currentShoeID = $_POST['currentShoeID'];
    $currentPrice = $service->getProductByID($currentShoeID)->getPrice();
    
    $currentCart->addProduct($currentShoeID, $currentSize, 1, $currentPrice);
}

else if(isset($_POST['cartIndex']))
{
    $currentCart->removeElement($_POST['cartIndex']);
}

else if(isset($_GET['quantityNum']))
{
    $cartIndex = $_GET['cartIndex'];
    $quantity = $_GET['quantityNum'];
    
    $currentCart->changeQuantity($cartIndex, $quantity);
}
$curretTotalPrice = $currentCart->getTotalPrice();

?>

<html>
	<head>
		<title>Revolution: Cart</title>
		<link rel="styleSheet" href="../../resources/css/CartStyle.css">
		<link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Syncopate" />
		<script src="../../resources/js/CartScript.js"></script>	
	</head>
	<body style="margin-top: 50px; background-color: white;">
	<div id="page-container">
		<div style="width: 100%; position: fixed; top: 0;">
			<?php 
    			session_start();
    			if(isset($_SESSION['currentUser']))
    			{
    			    include '../header/Header.php';
    			}
    		    else
    		    {
    		        include '../header/IndexHeader.php';
    		    }
			?>
		</div><br>
		
		<div class="searchGrid" align="center">
			<h2 style="font-family: syncopate">Your Cart</h2>
			<?php 
			     $shoeList = $currentCart->getProducts();
			     
			     for($i = 1; $i < count($shoeList); $i++)
			     {
			         $shoeID = $shoeList[$i][0];
			         $size = $shoeList[$i][1];
			         $quantity = $shoeList[$i][2];
			         $shoe = $service->getProductByID($shoeID);
			         
			         echo '<form method="POST" action="ShoppingCartPage.php"><table><tr>';
			         echo '<td><img src="data:image/jpeg;base64,'. base64_encode($shoe->getPicutre()) .'" alt="Shoe Picture" style="width:100px"></td>';
			         echo '<td style="width: 50%;"><a href="../product/ViewProduct.php?shoeID='. $shoe->getIdNum() .'">' . $shoe->getShoeName() . '</a></td>';
			         echo '<td>' . $size . '</td>';
			         echo '<td><input type="number" style="" name="quantity'. $i .'" onclick="myFunction(this)" min="0" max="100" value="'. $quantity .'"></td>';
			         echo '<td style="width: 20px;"><input type="submit" class="buttonClass" value="X"></td>';
			         echo '</tr></table>';
			         echo '<input type="hidden" name="cartIndex" value="'. $i .'"></form>';
			     }
			?>
			        	
        	<div style="width: 90%; text-align: right; font-family: syncopate;">
        		Total Price: $ <?php echo $curretTotalPrice;?>.00<br><br>
        		<form action="Checkout.php" method="GET">
        			<input class="button" type="submit" value="Checkout">
        		</form>
        	</div>
    	</div><br><br><br><br><br><br>
    	
    	<div class="footerStyle" align="center">
        	<table>
        		<tr>
        			<td>About Us</td>
        			<td>Contact Us</td>
        			<td>Learn More</td>
        			<td>Legal</td>
        		</tr>
        	</table>	
    	</div>
		</div>
	</body>
</html>