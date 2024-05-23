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
                            <p class="pizza-price">€{{ $pizza->price }}</p>
                            <label for="pizza-quantity">Aantal:</label>
                            <input type="number" class="pizza-quantity" value="1" min="1" max="99">
                            <button onclick="openpizza(this)" class="order-button" data-pizza="{{ $pizza->name }}">Bestel Nu</button>
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
                @foreach ($pizza_sizes as $size)
                <option value="{{ $size }}">{{ ucfirst($size) }}</option>
                @endforeach
            </select>
            <label for="ingredients" style="margin-bottom: 10px;">Kies ingrediënten:</label>
            <div class="ingredient-checkboxes">
                @foreach($ingredients as $ingredient)
                <div class="ingredient-checkbox">
                    <label>{{ $ingredient->name }}</label>
                    <input type="checkbox" name="ingredients[]" id="{{ $ingredient->name }}" value="{{ $ingredient->name }}">
                </div>
                @endforeach
            </div>


            <label for="pizza-customization">Aanpassingen:</label>
            <input type="text" id="pizza-customization" placeholder="Typ hier de aanpassingen...">
            <button onclick="addtocart(this)">Toevoegen aan winkelwagen</button>
        </section>
    </main>
    @include('footer')
</body>

</html>
