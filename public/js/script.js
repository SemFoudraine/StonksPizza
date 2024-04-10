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
        popup.style.zIndex = "1000";
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
    // Haal de hoeveelheid op van de input binnen de geselecteerde pizza-card
    const pizzaQuantityElement = document.querySelector('.pizza-card.selected .pizza-quantity');
    const quantity = parseInt(pizzaQuantityElement.value, 10);

    // Controleer of de hoeveelheid geldig is
    if (!isValidQuantity(quantity)) {
        alert('Voer een waarde in tussen 1 en 99.');
        return; // Stop de functie als de hoeveelheid niet geldig is
    }

    // Alles hieronder blijft ongewijzigd ten opzichte van de bestaande functie
    const pizzaSize = document.getElementById("pizza-size").value;
    const customization = document.getElementById("pizza-customization").value;
    const pizzaNameElement = document.querySelector('.pizza-card.selected .pizza-name');
    const pizzaName = pizzaNameElement.textContent;
    const pizzaPriceElement = document.querySelector('.pizza-card.selected .pizza-price');
    const pizzaPrice = parseFloat(pizzaPriceElement.textContent.replace('$', ''));
    const pizzaCustomization = customization.trim() === '' ? 'Niks' : customization;
    const pizza = {
        name: pizzaName,
        size: pizzaSize,
        customization: pizzaCustomization,
        quantity: quantity, // Gebruik de gevalideerde hoeveelheid
        price: pizzaPrice
    };
    const popup = document.createElement('div');
    popup.classList.add('popup');
    popup.textContent = `Toegevoegd: ${pizza.quantity}x ${pizza.name}`;
    document.body.appendChild(popup);

    setTimeout(() => {
        popup.classList.add('hidden')
        setTimeout(() => {
            popup.remove();
        }, 4000);
    }, 4000);

    let cart = [];
    if (sessionStorage.getItem("cart")) {
        cart = JSON.parse(sessionStorage.getItem("cart"));
    }
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
    document.getElementById("pizza-size").value = "small";
    document.getElementById("pizza-customization").value = "";
    closepizza();
    updateCartDisplay();
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
        cartItem.classList.add("cartbox");
        cartItem.innerHTML = `<h1>${pizza.name}</h1>
            <p>Size: ${pizza.size}</p>
            <p>Aanpassingen: ${pizza.customization}</p>
            <p>Prijs: ${pizza.price} - Aantal: <input class="pizzaamount" min="1" type="number" name="${index}_size" value="${pizza.quantity}" id="${index}_size"></p>
            <button onclick="updatePizza(${index})">Update</button>
            <button onclick="deletePizza(${index})">Verwijder</button>`;
        cartItemsContainer.appendChild(cartItem);
        cartItemsContainer.appendChild(middleLine);
        const summaryItem = document.createElement("div");
        summaryItem.classList.add("summary-item");
        const totalItemPrice = parseFloat(pizza.price) * parseInt(pizza.quantity);
        summaryItem.innerHTML = `<p>${pizza.quantity}x ${pizza.name} - ${pizza.size} - $${totalItemPrice.toFixed(2)}</p>`;
        summaryItemsContainer.appendChild(summaryItem);
        totalPizzaCount += parseInt(pizza.quantity);
        totalPrice += totalItemPrice;
    });
    cartCounter.textContent = totalPizzaCount;
    const priceSummary = document.createElement("div");
    const orderbtn = document.createElement("div");
    orderbtn.classList.add("order-btn");
    orderbtn.innerHTML = `<a href="/bedankt">Bestel Nu</a>`;
    priceSummary.classList.add("price-summary");
    priceSummary.innerHTML = `<p>Totaalprijs: $${totalPrice.toFixed(2)}</p>`;

    totalPriceContainer.innerHTML = "";
    totalPriceContainer.appendChild(priceSummary);
    totalPriceContainer.appendChild(orderbtn);
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


//

function isValidQuantity(quantity) {
    return quantity >= 1 && quantity <= 99;
}

