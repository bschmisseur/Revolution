<?php
include "../../business/ProductBusinessService.php";
session_start();

$service = new ProductBusinessService();
$currentCart = $_SESSION['currentCart'];

$street = $_POST['streetName'];
$city = $_POST['city'];
$state = $_POST['state'];
$zipCode = $_POST['zipCode'];
$country = $_POST['country'];
$cardNumber = $_POST['cardNumber'];
$nameOnCard = $_POST['nameOnCard'];
$experationDate = $_POST['experation'];
$securityCode = $_POST['securityCode'];

$address = $street . " " . $city  . " " . $state  . " " . $zipCode . " " . $country;

$completedTransaction = $service->completeTransaction($address, $cardNumber);

if($completedTransaction)
{
   unset($_SESSION['currentCart']);
   $_SESSION['currentCart'] = new ShoppingCart();
}

else {
    header("Location: Checkout.php"); 
}

?>

<html>
	<head>
		<title>Revolution: Cart</title>
		<link rel="styleSheet" href="../../resources/css/CheckoutStyle.css">
		<link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Syncopate" />
		<script src="../../resources/js/CartScript.js"></script>	
	</head>
	<body style="margin-top: 50px; background-color: white;">
		<div style="width: 100%; position: fixed; top: 0;">
			<?php
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
    		<div style="font-family: syncopate;" align="center">
    			<h2>Order Confirmation</h2>    			
    			<table class="tableLayout">
    				<tr>
    					<td style="border: 1px solid black;">
    						<h3>Purchased Products</h3>
    						<div class="searchGrid table-wrapper-scroll-y my-custom-scrollbar">
                                <?php 
                                     $shoeList = $currentCart->getProducts();
                                     
                                     for($i = 1; $i < count($shoeList); $i++)
                                     {
                                         $shoeID = $shoeList[$i][0];
                                         $size = $shoeList[$i][1];
                                         $shoe = $service->getProductByID($shoeID);
                                         
                                         echo '<table><tr>';
                                         echo '<td><img src="data:image/jpeg;base64,'. base64_encode($shoe->getPicutre()) .'" alt="Shoe Picture" style="width:100px"></td>';
                                         echo '<td style="width: 50%;"><a href="../product/ViewProduct.php?shoeID='. $shoe->getIdNum() .'">' . $shoe->getShoeName() . '</a></td>';
                                         echo '<td>' . $size . '</td>';
                                         echo '</tr></table><br>';
                                     }
                                ?>
    						</div>
    					</td>
    					<td style="border: 1px solid black; padding-left: 20px; width: 66%">
    						<h2>Order Summary</h2>
    						
    						<h3>Order Number</h3><br>
    						<?php echo $_SESSION['currentOrder']?>
    						
    						<h3>Address</h3><br>
    						<?php echo $address?>
    						
    						<h3>Card Information</h3><br>
    						<?php echo $cardNumber . "<br>" . $nameOnCard  . "<br>" . $experationDate  . "<br>" . $securityCode;?>
    						
    						<h3>Total Price</h3><br>
    						$<?php echo $currentCart->getTotalPrice()?>.00
    					</td>
    				</tr>
    			</table>
    		</div>
    		
    		<div style="width: 100%; text-align: center; font-family: syncopate;">
    			<form action="../home/HomePage.php" method="GET">
        			<input class="button" type="submit" value="Home Page">
        		</form>
            </div>
            
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
	</body>
</html>