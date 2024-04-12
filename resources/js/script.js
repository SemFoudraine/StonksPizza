function placeOrder(button) {
    var pizzaName = button.getAttribute('data-pizza');
    var pizzaSize = document.getElementById('pizza-size').value;
    var pizzaCustomization = document.getElementById('pizza-customization').value;
    var pizzaQuantity = document.getElementById('pizza-quantity').value;

    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            console.log(xhr.responseText);
            // Voeg hier eventuele extra verwerkingsstappen toe, zoals het bijwerken van de UI
        }
    };
    xhr.open("POST", "add_order.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send("pizzaName=" + pizzaName + "&pizzaSize=" + pizzaSize + "&pizzaCustomization=" + pizzaCustomization + "&pizzaQuantity=" + pizzaQuantity);
}
