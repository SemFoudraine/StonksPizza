<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/app.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,500,0,0" />
    <script src="js/script.js"></script>
    <title>Document</title>
</head>

<body>
    @include('header')
    <main>
        <section>
            <div class="container">
                <div class="pizza-container">
                    @foreach ($pizzas as $pizza)
                    <div class="pizza-card">
                        <img src="img/{{ $pizza->image }}" alt="{{ $pizza->name }}">
                        <div class="pizza-details">
                            <h2 class="pizza-name">{{ $pizza->name }}</h2>
                            <p class="pizza-description">{{ $pizza->description }}</p>
                            <p class="pizza-price">${{ $pizza->price }}</p>
                            <label for="pizza-quantity">Aantal:</label>
                            <input type="number" class="pizza-quantity" id="pizza-quantity" value="1" min="1" data-quantity="{{ $pizza->quantity }}">
                            <button onclick="openpizza(this)" class="order-button" data-pizza="{{ $pizza->name }}">Order Now</button>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>
        <section id="pizza-popup" class="pizza-popup">
            <span onclick="closepizza()" class="close-popup">x</span>
            <h2 id="pizza-popup-title">Pizza Naam</h2>
            <label for="pizza-size">Formaat:</label>
            <select id="pizza-size">
                <option value="small">Small</option>
                <option value="medium">Medium</option>
                <option value="large">Large</option>
            </select>
            <label for="pizza-customization">Aanpassingen:</label>
            <input type="text" id="pizza-customization" placeholder="Typ hier de aanpassingen...">
            <button onclick="addtocart(this)">Toevoegen aan winkelwagen</button>
        </section>
        <section id="cart-popup" class="shopping-cart">
            <div class="cart">
                <h1>Bestelling</h1>
                <ul id="cart-items"></ul>
            </div>
            <div class="contact-info">
                <h1>Contact Info</h1>
                    
                <button id="closecart" onclick="closecart()">Sluiten</button>
            </div>
            <div class="summary">
                <h1>Summary</h1>
                <div>
                    <div id="summary-items"></div>
                    <div id="total-price"></div>
                </div>
            </div>
        </section>
    </main>
    @include('footer')
</body>

</html>