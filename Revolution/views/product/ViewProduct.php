<?php 

include "../../business/ProductBusinessService.php";

$service = new ProductBusinessService();

$currentShoeID = $_GET['shoeID'];

$currentShoe = $service->getProductByID($currentShoeID);

?>
<html>
	<head>
		<title>Revolution: Product</title>
		<link rel="styleSheet" href="../../resources/css/ProductStyle.css">
		<link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Syncopate" />
	</head>
	<body style="margin-top: 50px; background-color: white;">
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
		
		<div class="productView" align="center">
			<form action="../checkout/ShoppingCartPage.php" method="POST">
			<input type="hidden" name="currentShoeID" value='<?php echo $currentShoeID ?>'>
    			<table style="border: 1px solid black; width: 90%">
        			<tr>
        				<td rowspan="2" style="width:50%; border-right: 1px solid black;">
            				<?php 
            				    echo '<img src="data:image/jpeg;base64,'. base64_encode($currentShoe->getPicutre()) .'" alt="Shoe Picture" style="width:100%">';
            				?>
        				</td>
        				<td style="text-align: center; height: 400">
        					<?php echo '<h2 style="font-family: syncopate;">'. $currentShoe->getShoeName() .'</h2>';
                                  echo '<p style="font-family: syncopate;">'. $currentShoe->getStyle() .'</p>';
                                  echo '<p style="font-family: syncopate;">$'. $currentShoe->getPrice() .'.00</p>'?>
        				</td>
        			</tr>
        			<tr>
        				<td>
            				<table style="font-family: syncopate; border-top: 1px solid black; text-align: center; width:100%;height: 60px;">
            					<tr>
            						<td style="width: 75%; border-right: 1px solid black;">
            							<?php 
            							
            							if(isset($_SESSION['currentUser']))
            							{
            							    //echo '<a href="">Purchase</a>';
            							    echo '<input type="submit" class="buttonClass" value="Purchase">';
            							}
            							else
            							{
            							    echo 'Purchase<br><br><div style="font-size: 9">You must be logged in to purchase</div>';
            							}
            							
            							?>
            						</td>
            						<td>
            							<div>
                                          <select name="sizeChoice">
                                            <option value="0">Select Size</option>
                                            <?php 
                                                $sizes = $currentShoe->getSizes();
                                                
                                                for($i = 0; $i < count($sizes); $i++)
                                                {
                                                    echo '<option value="'. $sizes[$i][0] .'">'. $sizes[$i][0] .'</option>';
                                                }
                                            ?>
                                          </select>
                                        </div>
    								</td>
            					</tr>
            				</table>
        				</td>
        			</tr>
    			</table>
			</form>
		</div>
		
		<div class="footer" align="center">
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