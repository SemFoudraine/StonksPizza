document.addEventListener("DOMContentLoaded", function () {
    var url = "/";
    if (document.URL == url) {
        const links = document.getElementById("header-links");
        document.getElementById("open-cart").style.display = "none";
        links.innerHTML + "<p></p>"
        const img = document.getElementById("carouselimg");
        const imgArray = ["img/home-1.png", "img/home-2.png", "img/home-3.png"];
        let currentImage = 1;
        setInterval(function () {
            img.src = imgArray[currentImage];
            currentImage = (currentImage + 1) % imgArray.length;
        }, 5000);
    } else {
        console.log("not on homepage");
    }

    const pizzaCards = document.querySelectorAll(".pizza-card");
    pizzaCards.forEach(function (card) {
        card.addEventListener("click", function () {
            pizzaCards.forEach(function (card) {
                card.classList.remove("selected");
            });
            card.classList.add("selected");
        });
    });

    updateCartDisplay();
});

function cardclicked() {
    window.location.href = "/menu";
}

function openpizza(button) {
    // Nieuw: Haal de hoeveelheid van de geselecteerde pizza op
    const pizzaQuantityElement = document.querySelector('.pizza-card.selected .pizza-quantity');
    const quantity = parseInt(pizzaQuantityElement.value, 10);

    // Controleer of de hoeveelheid geldig is
    if (!isValidQuantity(quantity)) {
        const popup = document.createElement('div');
        popup.classList.add('popup');
        popup.innerHTML = `Voer een waarde in tussen 1 en 99 <span class="popup-close" style="cursor:pointer; padding: 0 5px;">&times;</span>`;
        popup.style.backgroundColor = "red";
        popup.style.color = "white";
        popup.style.position = "fixed";
        popup.style.top = "70px";
        popup.style.right = "20px";
        popup.style.padding = "10px";
        popup.style.borderRadius = "5px";
        document.body.appendChild(popup);

        // Sluitfunctie voor de popup
        popup.querySelector('.popup-close').addEventListener('click', function () {
            popup.style.opacity = "0";
            popup.style.transition = "opacity 0.5s ease";
            setTimeout(() => {
                popup.remove();
            }, 500); // Wacht op de animatie om te voltooien voordat de popup wordt verwijderd
        });

        return; // Stop de functie als de hoeveelheid niet geldig is
    }

    // De rest van de openpizza functie blijft ongewijzigd
    const pizzaPopup = document.getElementById("pizza-popup");
    const cartPopup = document.getElementById("cart-popup");
    pizzaPopup.style.display = "block";
    cartPopup.style.display = "none";
    const pizzaName = button.dataset.pizza;
    document.getElementById("pizza-popup-title").textContent = pizzaName;
    pizzaPopup.style.opacity = "100";
    closecart();
}

function opencartwinkelwagen() {
    const cartPopup = document.getElementById("cart-popup");
    cartPopup.style.display = "flex";
    cartPopup.style.opacity = "100";
    closepizza();
}

function closecart() {
    const cartPopup = document.getElementById("cart-popup");
    cartPopup.style.opacity = "0";
    setTimeout(() => {
        cartPopup.style.display = "none";
    }, 500);
}

function closepizza() {
    const pizzaPopup = document.getElementById("pizza-popup");
    pizzaPopup.style.opacity = "0";
    setTimeout(() => {
        pizzaPopup.style.display = "none";
    }, 500);
}

document.addEventListener("DOMContentLoaded", function () {
    const pizzaCards = document.querySelectorAll(".pizza-card");
    pizzaCards.forEach(function (card) {
        card.addEventListener("click", function () {
            pizzaCards.forEach(function (card) {
                card.classList.remove("selected");
            });
            card.classList.add("selected");
        });
    });
});
function addtocart(button) {
    const pizzaQuantityElement = document.querySelector('.pizza-card.selected .pizza-quantity');
    const quantity = parseInt(pizzaQuantityElement.value, 10);

    if (!isValidQuantity(quantity)) {
        alert('Voer een waarde in tussen 1 en 99.');
        return;
    }

    const pizzaSize = document.getElementById("pizza-size").value;
    const customization = document.getElementById("pizza-customization").value;
    const pizzaNameElement = document.querySelector('.pizza-card.selected .pizza-name');
    const pizzaName = pizzaNameElement.textContent;
    const selectedIngredients = Array.from(document.querySelectorAll('.ingredient-checkboxes input[type="checkbox"]:checked')).map(checkbox => checkbox.value);

    const pizzaPriceElement = document.querySelector('.pizza-card.selected .pizza-price');
    const pizzaPrice = parseFloat(pizzaPriceElement.textContent.replace('€', ''));
    const pizzaCustomization = customization.trim() === '' ? 'Niks' : customization;
    const pizza = {
        name: pizzaName,
        size: pizzaSize,
        customization: pizzaCustomization,
        quantity: quantity,
        ingredients: selectedIngredients,
        price: pizzaPrice
    };

    let cart = JSON.parse(sessionStorage.getItem("cart")) || [];
    let pizzaExists = false;

    cart.forEach((item) => {
        if (item.name === pizza.name && item.size === pizza.size && item.customization === pizza.customization) {
            item.quantity += pizza.quantity;
            pizzaExists = true;
        }
    });

    if (!pizzaExists) {
        cart.push(pizza);
    }

    sessionStorage.setItem("cart", JSON.stringify(cart));
    updateCartDisplay();
    closepizza(); // Sluit de pop-up na het toevoegen aan de winkelwagen
}

function updateMap(latitude, longitude) {
    console.log("Updating map to:", latitude, longitude);

    if (!latitude || !longitude) {
        console.error("Latitude or longitude is undefined or incorrect.");
        return;
    }
    var apiKey = 'AIzaSyCcUU_2IudJMubc2UQW1yu9-HkWFy0u22c';
    var zoomLevel = 15;
    var googleMapIframe = document.getElementById('googleMap');

    if (googleMapIframe) {
        var iframeUrl =
            `https://www.google.com/maps/embed/v1/view?key=${apiKey}&center=${latitude},${longitude}&zoom=${zoomLevel}`;
        googleMapIframe.src = iframeUrl;
    } else {
        console.error('Element with id "googleMap" not found.');
    }
}



function updateCartDisplay() {
    const cartItemsContainer = document.getElementById("cart-items");
    const summaryItemsContainer = document.getElementById("summary-items");
    const totalPriceContainer = document.getElementById("total-price");
    const cartCounter = document.getElementById("cartcounter");
    const cart = JSON.parse(sessionStorage.getItem("cart")) || [];
    let totalPizzaCount = 0;
    let totalPrice = 0;
    cartItemsContainer.innerHTML = "";
    summaryItemsContainer.innerHTML = "";
    cart.forEach((pizza, index) => {
        const cartItem = document.createElement("div");
        const middleLine = document.createElement("hr");
        cartItem.classList.add("cartbox", "bg-white", "p-4", "shadow", "rounded-lg", "mb-4");
        cartItem.innerHTML = `
            <h1 class="text-lg font-bold">${pizza.name}</h1>
            <p>Size: ${pizza.size}</p>
            <p>Aanpassingen: ${pizza.customization}</p>
            <p>Ingrediënten: ${pizza.ingredients.join(', ')}</p>
            <div class="flex items-center justify-between">
                <p>Prijs: €${pizza.price}</p>
            </div>
            <label class="flex items-center">Aantal:
            <input class="pizzaamount ml-2 w-16 p-1 border rounded" type="number" min="1" name="${index}_size" value="${pizza.quantity}" id="${index}_size">
        </label>
            <div class="flex space-x-2 mt-2">
                <button class="bg-blue-100 hover:bg-blue-200 text-blue-800 font-bold py-1 px-3 rounded focus:outline-none focus:shadow-outline" onclick="updatePizza(${index})">Update</button>
                <button class="bg-red-100 hover:bg-red-200 text-red-800 font-bold py-1 px-3 rounded focus:outline-none focus:shadow-outline" onclick="deletePizza(${index})">Verwijder</button>
            </div>
        `;
        cartItemsContainer.appendChild(cartItem);
        cartItemsContainer.appendChild(middleLine);
        const summaryItem = document.createElement("div");
        summaryItem.classList.add("summary-item");
        const totalItemPrice = parseFloat(pizza.price) * parseInt(pizza.quantity);
        summaryItem.innerHTML = `<p>${pizza.quantity}x ${pizza.name} - ${pizza.size} - Ingrediënten: ${pizza.ingredients.join(', ')} - €${totalItemPrice.toFixed(2)}</p>`;
        summaryItemsContainer.appendChild(summaryItem);
        totalPizzaCount += parseInt(pizza.quantity);
        totalPrice += totalItemPrice;
    });
    cartCounter.textContent = totalPizzaCount;
    const priceSummary = document.createElement("div");
    priceSummary.classList.add("price-summary");
    priceSummary.innerHTML = `<p>Totaalprijs: €${totalPrice.toFixed(2)}</p>`;

    totalPriceContainer.innerHTML = "";
    totalPriceContainer.appendChild(priceSummary);
}

function isValidQuantity(quantity) {
    return quantity > 0 && quantity <= 99;
}

function openpizza(button) {
    const pizzaCard = button.closest('.pizza-card');
    pizzaCard.classList.add('selected');
    const pizzaName = button.getAttribute('data-pizza');
    document.getElementById('pizza-popup-title').textContent = pizzaName;
    document.getElementById('pizza-popup').style.display = 'block';
}

function closepizza() {
    const selectedPizzaCard = document.querySelector('.pizza-card.selected');
    if (selectedPizzaCard) {
        selectedPizzaCard.classList.remove('selected');
    }
    document.getElementById('pizza-popup').style.display = 'none';
}

function deletePizza(index) {
    let cart = JSON.parse(sessionStorage.getItem("cart")) || [];
    cart.splice(index, 1);
    sessionStorage.setItem("cart", JSON.stringify(cart));
    updateCartDisplay();
}
function updatePizza(index) {
    const newQuantity = parseInt(document.getElementById(`${index}_size`).value);
    let cart = JSON.parse(sessionStorage.getItem("cart")) || [];
    cart[index].quantity = newQuantity;
    sessionStorage.setItem("cart", JSON.stringify(cart));
    updateCartDisplay();
}

document.addEventListener("DOMContentLoaded", function () {
    updateCartDisplay();
});
function submitOrder() {
    event.preventDefault();

    const cart = JSON.parse(sessionStorage.getItem("cart")) || [];
    const total = cart.reduce((acc, item) => acc + item.price * item.quantity, 0);

    const formData = new FormData(document.getElementById('order-form'));
    formData.append('cart', JSON.stringify(cart));
    formData.append('total_price', total);

    axios.post('/orders', formData, {
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'multipart/form-data'
        }
    })
    .then(function(response) {
        console.log(response.data);

        const latitude = document.getElementById('latitude').value;
        const longitude = document.getElementById('longitude').value;

        sessionStorage.setItem('latitude', latitude);
        sessionStorage.setItem('longitude', longitude);

        sessionStorage.removeItem("cart");
        updateCartDisplay();

        window.location.href = '/bedankt';
    })
    .catch(function(error) {
        alert('Er is een fout opgetreden bij het plaatsen van de bestelling');
        console.error(error);
    });

    return false;
}


//

function isValidQuantity(quantity) {
    return quantity >= 1 && quantity <= 99;
}


    //let cartItems = [];
   // let totalPrice = 0;

    function addToCart(button) {
        let pizzaName = button.dataset.pizza.name;
        let pizzaPrice = button.dataset.pizza.price;
        let pizzaSize = document.getElementById('pizza-size').value;
        let quantity = document.getElementById('pizza-quantity').value;
        let customization = document.getElementById('pizza-customization').value;

        let item = {
            name: pizzaName,
            size: pizzaSize,
            price: pizzaPrice,
            quantity: quantity,
            customization: customization
        };

        cartItems.push(item);
        updateCart();
    }

    function updateCart() {
        let cartItemsList = document.getElementById('cart-items');
        cartItemsList.innerHTML = '';

        totalPrice = 0;

        cartItems.forEach(item => {
            let li = document.createElement('li');
            li.textContent = `${item.quantity}x ${item.size} ${item.name} - ${item.customization} - $${item.price}`;
            cartItemsList.appendChild(li);

            totalPrice += (parseInt(item.price) * parseInt(item.quantity));
        });

        document.getElementById('total-price').textContent = `Totaalprijs: $${totalPrice.toFixed(2)}`;
    }

    function cancelOrder() {
        cartItems = [];
        updateCart();
    }

    function checkout() {
        // Voeg hier de logica toe om de bestelling af te ronden
        // Dit kan een redirect naar een betaalpagina zijn of een bevestigingsbericht
        alert('Bestelling geplaatst! Bedankt voor uw aankoop.');
        cartItems = [];
        updateCart();
    }

