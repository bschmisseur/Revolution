<html>
	<head>
		<title>Revolution: Products</title>
		<link rel="styleSheet" href="../../resources/css/CardStyle.css">
		<link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Syncopate" />
	</head>
	<body style="margin-top: 50px; background-color: white;">
		<div style="width: 100%; position: fixed; top: 0;">
			<?php 
			    include "../../business/ProductBusinessService.php";
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
			<h2 style="font-family: syncopate">Shop All</h2>
			<table>
				<tr style="text-align: center">
        		<?php 
              		$service = new ProductBusinessService();
            		
            		$shoes = $service->viewProducts();
            		
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
    	</div><br>
		
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