<html>
	<head>
		<title>Revolution: Home</title>
		<link rel="styleSheet" href="../../resources/css/CardStyle.css">
		<link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Syncopate" />
	</head>
	<body style="margin-top: 50px; background-color: white;">
		<div style="width: 100%; position: fixed; top: 0; width: 100%;">
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
		</div>
		<img src="../../pictures/HomepageImage.jpg" width="100%" height="90%"><br>
		
		<table style="width: 100%">
			<tr>
				<td valign="middle" style="text-align: left"><br><h2 style="font-family: syncopate;">Featured Products</h2><br></td>
				<td style="text-align: right">
					<form method="GET" action="../product/ViewAllProducts.php">
						<input class="button" type="submit" value="View All">
					</form>
				</td>
			</tr>
		</table>
		
		<div class="horScroll" style="overflow-x:auto;">
  			<table>
  				<tr>
            		<?php 
                 		include "../../business/ProductBusinessService.php";
                		
                  		$service = new ProductBusinessService();
                		
                		$shoes = $service->viewProducts();
                		
                		for($i = 0; $i < 10; $i++)
                		{
                		    $currentShoe = $shoes[$i];
                		    
                		    echo '<td><div class="card">';
                		    echo '<a  href="../product/ViewProduct.php?shoeID='. $currentShoe->getIdNum() .'">';
                		    echo '<img src="data:image/jpeg;base64,'. base64_encode($currentShoe->getPicutre()) .'" alt="Shoe Picture" style="width:100%">';
                		    echo '<div class="container">';
                		    echo '<h4><b>'. $currentShoe->getShoeName() .'</b></h4> ';
                		    echo '<p>$'. $currentShoe->getPrice() .'</p> ';
                		    echo '</div></a></div><td>';
                		}
                	?>
            	</tr>
        	</table>
    	</div>
		
		<table style="width: 100%">
			<tr>
				<td valign="middle" style="text-align: left"><br><h2 style="font-family: syncopate;">Shop Nike</h2><br></td>
				<td style="text-align: right">
					<form method="GET" action="../product/SearchProduct.php">
						<input class="button" type="submit" value="View All">
						<input type="hidden" name="searchParam" value="Nike">
					</form>
				</td>
			</tr>
		</table>
		
		
		<div class="searchGrid" align="center">
			<table>
				<tr style="text-align: center">
        		<?php 
              		$service = new ProductBusinessService();
            		
            		$shoes = $service->searchProducts("nike");
            		
            		for($i = 0; $i < count($shoes); $i++)
            		{
            		    $currentShoe = $shoes[$i];
            		    
            		    echo '<td><div class="cardInside">';
            		    echo '<a  href="../product/ViewProduct.php?shoeID='. $currentShoe->getIdNum() .'">';
            		    echo '<img src="data:image/jpeg;base64,'. base64_encode($currentShoe->getPicutre()) .'" alt="Shoe Picture" style="width:100%">';
            		    echo '<div class="containerInside">';
            		    echo '<br><h4><b>'. $currentShoe->getShoeName() .'</b></h4> ';
            		    echo '</div></a></div></td>';
            		    
            		    if(($i + 1) % 4 == 0)
            		    {
            		        echo "</tr><tr>";
            		    }
            		}
            		
            	?>
            	</tr>
        	</table>
    	</div>
    	
    			<table style="width: 100%">
			<tr>
				<td valign="middle" style="text-align: left"><br><h2 style="font-family: syncopate;">Shop Adidas</h2><br></td>
				<td style="text-align: right">
					<form method="GET" action="../product/SearchProduct.php">
						<input class="button" type="submit" value="View All">
						<input type="hidden" name="searchParam" value="Adidas">
					</form>
				</td>
			</tr>
		</table>
		
		
		<div class="searchGrid" align="center">
			<table>
				<tr style="text-align: center">
        		<?php 
              		$service = new ProductBusinessService();
            		
            		$shoes = $service->searchProducts("adidas");
            		
            		for($i = 0; $i < count($shoes); $i++)
            		{
            		    $currentShoe = $shoes[$i];
            		    
            		    echo '<td><div class="cardInside">';
            		    echo '<a  href="../product/ViewProduct.php?shoeID='. $currentShoe->getIdNum() .'">';
            		    echo '<img src="data:image/jpeg;base64,'. base64_encode($currentShoe->getPicutre()) .'" alt="Shoe Picture" style="width:100%">';
            		    echo '<div class="containerInside">';
            		    echo '<br><h4><b>'. $currentShoe->getShoeName() .'</b></h4> ';
            		    echo '</div></a></div></td>';
            		    
            		    if(($i + 1) % 4 == 0)
            		    {
            		        echo "</tr><tr>";
            		    }
            		}
            		
            	?>
            	</tr>
        	</table>
    	</div>
    	<br><br>
    	
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