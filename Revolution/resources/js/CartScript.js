function myFunction(input)
{
    var cartIndexNumber = input.getAttribute("name").substring(8);
    var quantityNum = input.value;
    var nunberOutput = document.getElementById("numberOutput");

    window.location.href = "ShoppingCartPage.php".concat("?cartIndex=", cartIndexNumber, '&quantityNum=', quantityNum);
}