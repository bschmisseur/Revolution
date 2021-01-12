<?php 

include "../../business/UserBusinessService.php";
include "../../business/ProductBusinessService.php";
include "../../business/AddressBusinessService.php";
include "../../business/CreditCardBusinessService.php";
include '../../business/OrderBusinessService.php';
session_start();

$userService = new UserBusinessService();
$productService = new ProductBusinessService();
$addressService = new AddressBusinessService();
$cardService = new CreditCardBusinessService();
$orderService = new OrderBusinessService();
$currentUser = $_SESSION['currentUser'];
$currentProduct = 0;
$currentAddress = $addressService->viewAddressByUserId($currentUser->getIdNum());
$currentCard = $cardService->viewCardByUserId($currentUser->getIdNum());
$userPermission = $userService->getPermission();

$midPage = "";
$rightPage = "No Display";

if(isset($_GET['midPage']))
{
    $midPage = $_GET['midPage'];
    $rightPage = "No Display";
}

if(isset($_GET['rightPage']))
{
    $rightPage = $_GET['rightPage'];
    
    if(strcmp($rightPage, "addProductFrom") == 0)
    {
        $midPage = "adminInfo";
    }
}

if(isset($_GET['shoeID']))
{
    $rightPage = "editProduct";
    $midPage = "adminInfo";
    $currentProductID = $_GET['shoeID'];
    $currentProduct = $productService->getProductByID($currentProductID);
}

if(isset($_POST['changeData']))
{
    $action = $_POST['changeData'];
    if(strcmp($action, "editUserInfo") == 0)
    {
        $firstName = $_POST['firstName'];
        $lastName = $_POST['lastName'];
        $userName = $_POST['userName'];
        $password = $_POST['password'];
        $email = $_POST['email'];
        $phoneNumber = $_POST['phoneNumber'];
        
        $editedUser = new User($currentUser->getIdNum(), $firstName, $lastName, $userName, $password, $email, $phoneNumber, $userPermission);
        $userService->updateUser($editedUser);
        $currentUser = $editedUser;
        $_SESSION['currentUser'] = $editedUser;
        $rightPage = "userInfo";
        $midPage = "user";
    }
    
    elseif(strcmp($action, "editAddress") == 0)
    {
        $street = $_POST['streetName'];
        $city = $_POST['city'];
        $state = $_POST['state'];
        $zipCode = $_POST['zipCode'];
        $country = $_POST['country'];
        
        $editedAddress = new Address($street, $city, $state, $zipCode, $country);
        
        $addressService->createAddress($editedAddress);
        $currentAddress = $editedAddress;
        $rightPage = "address";
        $midPage = "user";
    }
    elseif(strcmp($action, "editCard") == 0)
    {
        $cardNumber = $_POST['cardNumber'];
        $nameOnCard = $_POST['nameOnCard'];
        $experationDate = $_POST['experation'];
        $securityCode = $_POST['securityCode'];
        
        $editedCard = new CreditCard($cardNumber, $nameOnCard, $experationDate, $securityCode);
        
        $cardService->createCard($editedCard);
        $currentCard = $editedCard;
        $rightPage = "creditCard";
        $midPage = "user";
    }
    
    elseif(strcmp($action, "editProduct") == 0)
    {
        $editedProduct = null; 
        $currentProductID = $_POST['currentProductID'];
        $currentProduct = $productService->getProductByID($currentProductID);
        $shoeName = $_POST['shoeName'];
        $brand = $_POST['brand'];
        $price = $_POST['price'];
        $styleNumber = $_POST['styleNumber'];
        
        $editedProduct = new Product($currentProductID, $shoeName, $brand, $price, $styleNumber, $currentProduct->getPicutre(), $currentProduct->getSizes());
        $productService->updateProduct($editedProduct);
        
        $picture = $_FILES['shoePicture']['tmp_name'];
        
        if($picture != NULL)
        {
            $editedProduct = new Product($currentProductID, $shoeName, $brand, $price, $styleNumber, $picture, $currentProduct->getSizes());
            $productService->editProduct($editedProduct, $picture);
        }
        
        else
        {
            $editedProduct = new Product($currentProductID, $shoeName, $brand, $price, $styleNumber, $currentProduct->getPicutre(), $currentProduct->getSizes());
            $productService->updateProduct($editedProduct);
        }
        
        $rightPage = "products";
        $midPage = "adminInfo";
    }
    
    elseif(strcmp($action, "addProduct") == 0)
    {
        $shoeName = $_POST['shoeName'];
        $brand = $_POST['brand'];
        $price = $_POST['price'];
        $styleNumber = $_POST['styleNumber'];
        $picture = $_FILES['shoePicture']['tmp_name'];
        
        $newProduct = new Product(0, $shoeName, $brand, $price, $styleNumber, $picture, NULL);
        
        $productService->createProduct($newProduct);
        
        $rightPage = "products";
        $midPage = "adminInfo";
    }
}

?>
<html>
	<head>
		<title>Revolution: User Information</title>
		<link rel="styleSheet" href="../../resources/css/UserInformationStyle.css">
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
			<h2>User Information</h2>
			<table class="tableLayout">
				<tr>
					<td style="border: 1px solid black; width: 33%">
						<table style="width: 100%">
							<tr>
								<td>
    								<form method="GET" action="UserInformation.php">
    									<input type="submit" class="button" value="User">
    									<input type="hidden" value="user" name="midPage">
    								</form>
								</td>
							</tr>
							<tr>
								<?php 
								    if(strcmp("ADMIN", $userPermission) == 0)
								    {
								        echo '<td><form method="GET" action="UserInformation.php">
    							              <input type="submit" class="button" value="Admin">
                                              <input type="hidden" value="adminInfo" name="midPage">
    							              </form></td>';
								    }
								?>
							</tr>
						</table>
					</td>
					<?php 
					if(strcmp("salesInfo", $rightPage) != 0)
					   {
					       ///////////Middle page\\\\\\\\\\\
					       
					       echo '<td style="border: 1px solid black; width: 33%">';
					       
					       if(strcmp("user", $midPage) == 0)
					       {
					           echo '<table style="width: 100%">
    							     <tr><td><form method="GET" action="UserInformation.php">
    							     <input type="submit" class="button" value="User Information">
                                     <input type="hidden" value="userInfo" name="rightPage">
                                     <input type="hidden" value="user" name="midPage">
    							     </form></tr></td>
                                     <tr><td><form method="GET" action="UserInformation.php">
    							     <input type="submit" class="button" value="Address">
                                     <input type="hidden" value="address" name="rightPage">
                                     <input type="hidden" value="user" name="midPage">
    							     </form></tr></td>
    							     <tr><td><form method="GET" action="UserInformation.php">
    							     <input type="submit" class="button" value="Credit Card Info">
                                     <input type="hidden" value="creditCard" name="rightPage">
                                     <input type="hidden" value="user" name="midPage">
    							     </form></tr></td>
                                     </table>';  
					       }
					       
					       elseif(strcmp("adminInfo", $midPage) == 0)
					       {
					           echo '<table style="width: 100%">
    							     <tr><td><form method="GET" action="UserInformation.php">
    							     <input type="submit" class="button" value="Sales Report">
                                     <input type="hidden" value="salesInfo" name="rightPage">
                                     <input type="hidden" value="adminInfo" name="midPage">
    							     </form></tr></td>
                                     <tr><td><form method="GET" action="UserInformation.php">
    							     <input type="submit" class="button" value="Products">
                                     <input type="hidden" value="products" name="rightPage">
                                     <input type="hidden" value="adminInfo" name="midPage">
    							     </form></tr></td>
    							     <tr><td><form method="GET" action="UserInformation.php">
    							     <input type="submit" class="button" value="Users">
                                     <input type="hidden" value="users" name="rightPage">
                                     <input type="hidden" value="adminInfo" name="midPage">
    							     </form></tr></td>
                                     </table>';  
					       }
					       
					       echo '</td><td style="border: 1px solid black; width: 33%">';
					       
					       ///////////Right page\\\\\\\\\\\
					       
					       if(strcmp("products", $rightPage) == 0)
					       {
					           echo '<div style="height: 100%" class="searchGrid table-wrapper-scroll-y my-custom-scrollbar">';
					           
					           $shoeList = $productService->viewProducts();
					           
					           for($i = 1; $i < count($shoeList); $i++)
					           {
					               $shoe = $shoeList[$i];

					               echo '<table><tr>';
					               echo '<td><img src="data:image/jpeg;base64,'. base64_encode($shoe->getPicutre()) .'" alt="Shoe Picture" style="width:100px"></td>';
					               echo '<td style="width: 50%;"><a href="UserInformation.php?shoeID='. $shoe->getIdNum() .'">' . $shoe->getShoeName() . '</a></td>';
					               echo '</tr></table><br>';
					           }
					           
					           echo '<table><tr>';
					           echo '<td style="width: 50%;"><a href="UserInformation.php?rightPage=addProductForm">+ Add New Product</a></td>';
					           echo '</tr></table><br>';
					           
					           echo '</div>';
					       }
					       
					       elseif(strcmp("users", $rightPage) == 0)
					       {
					           echo '<div style="height: 100%" class="searchGrid table-wrapper-scroll-y my-custom-scrollbar">';
					           
					           $usersList = $userService->viewAllUsers();
					           
					           for($i = 0; $i < count($usersList); $i++)
					           {
					               $user = $usersList[$i];
					               
					               echo '<table><tr>';
					               echo '<td><b> ' . $user->getFirstName() . ' ' . $user->getLastName() . '<b></td>';
					               echo '<td>' . $user->getUserName() . '</td>';
					               echo '</tr></table><br>';
					           }
					           
					           echo '</div>';
					       }
					       
					       elseif(strcmp("userInfo", $rightPage) == 0)
					       {
					           
					           echo '<h2>User Info</h2>';
					           echo '<div style="height: 90%" class="searchGrid table-wrapper-scroll-y my-custom-scrollbar">';
					           echo '<form style="padding-top: 23px" class="login-form" method="POST" action="UserInformation.php">
                                			<div class="group">      
                                			    <input type="text" name="firstName" value="' .  $currentUser->getFirstName() . '" required>
                                			    <span class="highlight"></span>
                                			    <span class="bar"></span>
                                			    <label>First Name</label>
                                		    </div>
                                		    <div class="group">      
                                			    <input type="text" name="lastName" value="' .  $currentUser->getLastName() . '" required>
                                			    <span class="highlight"></span>
                                			    <span class="bar"></span>
                                			    <label>Last Name</label>
                                		    </div>
                                		    <div class="group">      
                                			    <input type="text" name="userName" value="' .  $currentUser->getUserName() . '" required>
                                			    <span class="highlight"></span>
                                			    <span class="bar"></span>
                                			    <label>User Name</label>
                                		    </div>
                                		    <div class="group">      
                                			    <input type="password" name="password" value="' .  $currentUser->getPassword() . '" required>
                                			    <span class="highlight"></span>
                                			    <span class="bar"></span>
                                			    <label>Password</label>
                                		    </div>
                                		    <div class="group">      
                                			    <input type="text" name="email" value="' .  $currentUser->getEmail() . '" required>
                                			    <span class="highlight"></span>
                                			    <span class="bar"></span>
                                			    <label>Email</label>
                                		    </div>
                                		    <div class="group">      
                                			    <input type="text" name="phoneNumber" value="' .  $currentUser->getPhoneNumber() . '" required>
                                			    <span class="highlight"></span>
                                			    <span class="bar"></span>
                                			    <label>Phone Number</label>
                                		    </div>
                                            <input type="hidden" name="changeData" value="editUserInfo">
                                			<input class="button" type="submit" value="Edit">
                                            <button style="width: 90%" class="button">Delete User</button>
                                		</form></div>';
					     
					       }
					       
					       
					       elseif(strcmp("address", $rightPage) == 0)
					       {
					           echo '<h2>Address</h2>';
					           echo '<div style="height: 90%" class="searchGrid table-wrapper-scroll-y my-custom-scrollbar">';
					           echo '<form style="padding-top: 23px" method="POST" action="UserInformation.php"><div class="group">
                        			    <input type="text" name="streetName" value="' .  $currentAddress->getStreetName() . '" required>
                        			    <span class="highlight"></span>
                        			    <span class="bar"></span>
                        			    <label>Street Name</label>
                        		    </div>
                                			        
                        		    <div class="group">
                        			    <input type="text" name="city" value="' .  $currentAddress->getCity() . '" required>
                        			    <span class="highlight"></span>
                        			    <span class="bar"></span>
                        			    <label>City</label>
                        		    </div>
                                			        
                        		    <div class="group">
                        			    <input type="text" name="state" value="' .  $currentAddress->getState() . '" required>
                        			    <span class="highlight"></span>
                        			    <span class="bar"></span>
                        			    <label>State</label>
                        		    </div>
                                			        
                        		    <div class="group">
                        			    <input type="text" name="zipCode" value="' .  $currentAddress->getZipCode() . '" required>
                        			    <span class="highlight"></span>
                        			    <span class="bar"></span>
                        			    <label>Zip Code</label>
                        		    </div>
                                			        
                        		    <div class="group">
                        			    <input type="text" name="country" value="' .  $currentAddress->getCountry() . '" required>
                        			    <span class="highlight"></span>
                        			    <span class="bar"></span>
                        			    <label>Country</label>
                                    <input type="hidden" name="changeData" value="editAddress">
                        		    </div><input class="button" type="submit" value="Edit">
                                    </form>';
					           echo '</div>';
					       }
					       
					       elseif(strcmp("creditCard", $rightPage) == 0)
					       {
					           echo '<h2>Credit Card</h2>';
					           echo '<div style="height: 90%" class="searchGrid table-wrapper-scroll-y my-custom-scrollbar">';
					           echo '<form style="padding-top: 23px" method="POST" action="UserInformation.php">
                                    <div class="group">      
                        			    <input type="text" name="cardNumber" value="' .  $currentCard->getCardNumber() . '" required>
                        			    <span class="highlight"></span>
                        			    <span class="bar"></span>
                        			    <label>Card Number</label>
                        		    </div>
                        		    
                        		    <div class="group">      
                        			    <input type="text" name="nameOnCard" value="' .  $currentCard->getNameOnCard() . '" required>
                        			    <span class="highlight"></span>
                        			    <span class="bar"></span>
                        			    <label>Name On Card</label>
                        		    </div>
                        		    
                        		    <div class="group">      
                        			    <input type="text" name="experation" value="' .  $currentCard->getExperationDate() . '" required>
                        			    <span class="highlight"></span>
                        			    <span class="bar"></span>
                        			    <label>Experation Date</label>
                        		    </div>
                        		    
                        		    <div class="group">      
                        			    <input type="text" name="securityCode" value="' .  $currentCard->getSecurityCode() . '" required>
                        			    <span class="highlight"></span>
                        			    <span class="bar"></span>
                        			    <label>Security Code</label>
                        		    </div>
                        		    <input class="button" type="submit" value="Edit">
                        		    <input type="hidden" name="changeData" value="editCard"> </form></div>';
        					       }
        					       
					       elseif(strcmp("editProduct", $rightPage) == 0)
					       {
					           echo '<h2>Product Info</h2>';
					           echo '<div style="height: 90%" class="searchGrid table-wrapper-scroll-y my-custom-scrollbar">';
 					           echo '<form style="padding-top: 23px"  enctype="multipart/form-data" method="POST" action="UserInformation.php">';
                        	   echo '<div class="group">
                        			    <input type="text" name="shoeName" value="' .  $currentProduct->getShoeName() . '" required>
                        			    <span class="highlight"></span>
                        			    <span class="bar"></span>
                        			    <label>Shoe Name</label>
                        		    </div>';
                        		echo '<div class="group">
                        			    <input type="text" name="brand" value="' .  $currentProduct->getBrand() . '" required>
                        			    <span class="highlight"></span>
                        			    <span class="bar"></span>
                        			    <label>Brand</label>
                        		    </div>';
                        		echo '<div class="group">
                        			    <input type="text" name="price" value="' .  $currentProduct->getPrice() . '" required>
                        			    <span class="highlight"></span>
                        			    <span class="bar"></span>
                        			    <label>Price</label>
                        		    </div>';
                        		 echo '<div class="group">
                        			    <input type="text" name="styleNumber" value="' .  $currentProduct->getStyle() . '" required>
                        			    <span class="highlight"></span>
                        			    <span class="bar"></span>
                        			    <label>Style Number</label>
                        		    </div>';
                        		 echo '<div class="group" text-align="center">
                                    <input type="file" name="shoePicture" accept="image/*">
                                    <label>Picture</label></div>
                                    <input type="hidden" name="currentProductID" value="' . $currentProduct->getIdNum() . '">
                                    <input type="hidden" name="changeData" value="editProduct">
                        		    <input class="button" type="submit" value="Edit">
                        		    <button style="width: 90%" class="button">Delete Product</button>';
                         		    echo '</form></div>';
        					  }
					   
    					   elseif(strcmp("addProductForm", $rightPage) == 0)
    					   {
    					       echo '<h2>Add Product</h2>';
    					       echo '<div style="height: 90%" class="searchGrid table-wrapper-scroll-y my-custom-scrollbar">';
    					       echo '<form style="padding-top: 23px"  enctype="multipart/form-data" method="POST" action="UserInformation.php">';
    					       echo '<div class="group">
                            			    <input type="text" name="shoeName" required>
                            			    <span class="highlight"></span>
                            			    <span class="bar"></span>
                            			    <label>Shoe Name</label>
                            		    </div>';
    					       echo '<div class="group">
                            			    <input type="text" name="brand" required>
                            			    <span class="highlight"></span>
                            			    <span class="bar"></span>
                            			    <label>Brand</label>
                            		    </div>';
    					       echo '<div class="group">
                            			    <input type="text" name="price" required>
                            			    <span class="highlight"></span>
                            			    <span class="bar"></span>
                            			    <label>Price</label>
                            		    </div>';
    					       echo '<div class="group">
                            			    <input type="text" name="styleNumber" required>
                            			    <span class="highlight"></span>
                            			    <span class="bar"></span>
                            			    <label>Style Number</label>
                            		    </div>';
    					       echo '<div class="group" text-align="center">
                                        <input type="file" name="shoePicture" accept="image/*">
                                        <label>Picture</label></div>
                                        <input type="hidden" name="changeData" value="addProduct">
                            		    <input class="button" type="submit" value="Add Product">';
    					       echo '</form></div>';
    					   }
					   
					       echo '</td>';
					   }
					   
					   elseif(strcmp("salesInfo", $rightPage) == 0)
					   {
					       echo '<td style="border: 1px solid black; width: 66%">';
					       echo '<h2>Sale Report</h2>';
					       echo '<div style="height: 90%" class="searchGrid table-wrapper-scroll-y my-custom-scrollbar">';
					       echo '<table style="font-size: 10px"><tr><th>Number</th><th>Address</th><th>Card Number</th><th>Total Price</th><th>Number Of Products</th></tr>';
					       
					       $orderList = $orderService->viewAllOrders();
					       
					       for($i = 0; $i < count($orderList); $i++)
					       {
					           $currentOrder = $orderList[$i];
					           
					           echo '<tr>';
					           echo '<td>' . $currentOrder->getNumber() . '</td>';
					           echo '<td>' . $currentOrder->getAddresss() . '</td>';
					           echo '<td>' . $currentOrder->getCardNumber() . '</td>';
					           echo '<td>' . $currentOrder->getTotalPrice() . '</td>';
					           echo '<td>' . $currentOrder->getNumberOfProducts() . '</td>';
					           echo '</tr>';
					       }
					       
					       echo '<div></table></td>';
					   }
					?>
				</tr>
			</table>
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