<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/app.css">
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
                        <img src="../img/{{ $pizza->image }}" alt="{{ $pizza->name }}">
                        <div class="pizza-details">
                            <h2 class="pizza-name">{{ $pizza->name }}</h2>
                            <p class="pizza-description">{{ $pizza->description }}</p>
                            <p class="pizza-price">€{{ $pizza->price }}</p>
                            <label for="pizza-quantity">Aantal:</label>
                            <input type="number" class="pizza-quantity" id="pizza-quantity" value="1" min="1" max="99" data-quantity="{{ $pizza->quantity }}">
                            <button onclick="openpizza(this)" class="order-button" data-pizza="{{ $pizza->name }}">Bestel Nu</button>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>
        <section id="add-pizza-section">
            <h2>Pizza Toevoegen</h2>
            <form action="{{ route('pizza.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <label for="pizza-name">Naam:</label>
                <input type="text" id="pizza-name" name="name" required>

                <label for="pizza-description">Beschrijving:</label>
                <textarea id="pizza-description" name="description" rows="3" required></textarea>

                <label for="pizza-price">Prijs:</label>
                <input type="number" id="pizza-price" name="price" min="0" step="0.01" required>

                <label for="calories">Calories:</label>
                <input type="number" id="calories" name="calories" min="0" step="1"> <!-- Laat het veld optioneel -->

                <label for="pizza-image">Afbeelding:</label>
                <input type="file" id="pizza-image" name="image" accept="image/*" required>

                <button type="submit">Pizza Toevoegen</button>
            </form>
        </section>
    </main>
    @include('footer')
</body>

</html>
