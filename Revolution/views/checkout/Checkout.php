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
			    include_once "../../business/ProductBusinessService.php";
			    include "../../business/AddressBusinessService.php";
			    include "../../business/CreditCardBusinessService.php";
			    session_start();
			    
			    $currentUserID = $_SESSION['currentUser']->getIdNum();
			    
			    $service = new ProductBusinessService();
			    $addressService = new AddressBusinessService();
			    $cardService = new CreditCardBusinessService();
			    
			    $currentAddress = $addressService->viewAddressByUserId($currentUserID);
			    $currentCard = $cardService->viewCardByUserId($currentUserID);
			    $currentCart = $_SESSION['currentCart'];
			    
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
		<form action="OrderConfirmation.php" method="POST">
    		<div style="font-family: syncopate;" align="center">
    			<h2>Checkout</h2>
    			<table class="tableLayout">
    				<tr>
    					<td style="border: 1px solid black;">
    						<h3>Cart</h3>
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
    					<td style="border: 1px solid black; padding-left: 20px;">
    						<h3>Shipping</h3><br>
    						<div class="group">      
                			    <input type="text" name="streetName" value="<?php echo $currentAddress->getStreetName();?>" required>
                			    <span class="highlight"></span>
                			    <span class="bar"></span>
                			    <label>Street Name</label>
                		    </div>
                		    
                		    <div class="group">      
                			    <input type="text" name="city" value="<?php echo $currentAddress->getCity();?>" required>
                			    <span class="highlight"></span>
                			    <span class="bar"></span>
                			    <label>City</label>
                		    </div>
                		    
                		    <div class="group">      
                			    <input type="text" name="state" value="<?php echo $currentAddress->getState();?>" required>
                			    <span class="highlight"></span>
                			    <span class="bar"></span>
                			    <label>State</label>
                		    </div>
                		    
                		    <div class="group">      
                			    <input type="text" name="zipCode" value="<?php echo $currentAddress->getZipCode();?>" required>
                			    <span class="highlight"></span>
                			    <span class="bar"></span>
                			    <label>Zip Code</label>
                		    </div>
                		    
                		    <div class="group">      
                			    <input type="text" name="country" value="<?php echo $currentAddress->getCountry();?>" required>
                			    <span class="highlight"></span>
                			    <span class="bar"></span>
                			    <label>Country</label>
                		    </div>
    					</td>
    					<td style="border: 1px solid black;">
    						<h3>Billing</h3><br>
    						
    						<div class="group">      
                			    <input type="text" name="cardNumber" value="<?php echo $currentCard->getCardNumber();?>" required>
                			    <span class="highlight"></span>
                			    <span class="bar"></span>
                			    <label>Card Number</label>
                		    </div>
                		    
                		    <div class="group">      
                			    <input type="text" name="nameOnCard" value="<?php echo $currentCard->getNameOnCard();?>" required>
                			    <span class="highlight"></span>
                			    <span class="bar"></span>
                			    <label>Name On Card</label>
                		    </div>
                		    
                		    <div class="group">      
                			    <input type="text" name="experation" value="<?php echo $currentCard->getExperationDate();?>" required>
                			    <span class="highlight"></span>
                			    <span class="bar"></span>
                			    <label>Experation Date</label>
                		    </div>
                		    
                		    <div class="group">      
                			    <input type="text" name="securityCode" value="<?php echo $currentCard->getSecurityCode();?>" required>
                			    <span class="highlight"></span>
                			    <span class="bar"></span>
                			    <label>Security Code</label>
                		    </div>
                		    
                		    <h3>Total Price: $ <?php echo $currentCart->getTotalPrice()?>.00</h3>
    					</td>
    				</tr>
    			</table>
    		</div>
    		
    		<div style="width: 100%; text-align: center; font-family: syncopate;">
        		<input class="button" type="submit" value="Confirm">
            </div>
		</form>
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