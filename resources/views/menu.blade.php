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
            <div class="pizza-container">
                @foreach ($pizzas as $pizza)
                <div class="pizza-card">
                    <img src="img/{{ $pizza->image }}" alt="{{ $pizza->name }}">
                    <div class="pizza-details">
                        <h2 class="pizza-name">{{ $pizza->name }}</h2>
                        <p class="pizza-description">{{ $pizza->description }}</p>
                        <p class="pizza-price">${{ $pizza->price }}</p>
                        <label for="pizza-quantity">Aantal:</label>
                        <input type="number" class="pizza-quantity" id="pizza-quantity" value="1" min="1" max="99" data-quantity="{{ $pizza->quantity }}">
                        <!-- Voeg het bestelformulier toe voor elke pizza -->
                        <form id="order-form-{{ $pizza->id }}" class="order-form" data-pizza-id="{{ $pizza->id }}">
                            @csrf <!-- Voeg een CSRF-token toe voor beveiliging -->
                            <input type="hidden" name="pizza_id" value="{{ $pizza->id }}"> <!-- Voeg een verborgen veld toe om de pizza-ID door te geven -->
                            <button type="submit" class="order-button">Bestel Nu</button>
                        </form>
                    </div>
                </div>
                @endforeach
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
    </main>
    @include('footer')

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Voeg een event listener toe voor het indienen van het bestelformulier
            document.querySelectorAll('.order-form').forEach(form => {
                form.addEventListener('submit', function (event) {
                    event.preventDefault(); // Voorkom standaardgedrag van het formulier (paginaherladen)

                    // Haal pizza-ID op uit het formulier
                    const pizzaId = this.dataset.pizzaId;

                    // Doe een asynchrone POST-request naar de server
                    fetch('{{ route('place.order') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}' // Voeg de CSRF-token toe aan de headers
                        },
                        body: JSON.stringify({ // Verzend de gegevens van het formulier als JSON
                            pizza_id: pizzaId
                        })
                    })
                    .then(response => {
                        if (response.ok) {
                            return response.json(); // Verwerk het JSON-antwoord
                        } else {
                            throw new Error('Bestelling kon niet worden geplaatst');
                        }
                    })
                    .then(data => {
                        // Redirect naar de bedankpagina met het ordernummer
                        window.location.href = '/bedankt?order_number=' + data.order_number;
                    })
                    .catch(error => {
                        console.error('Er is een fout opgetreden bij het plaatsen van de bestelling:', error);
                        // Toon een foutmelding aan de gebruiker
                        alert('Er is een fout opgetreden bij het plaatsen van de bestelling. Probeer het later opnieuw.');
                    });
                });
            });
        });
    </script>
</body>

</html>
