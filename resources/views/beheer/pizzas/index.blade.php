<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,500,0,0" />
    <script src="js/script.js"></script>
    <title>Document</title>
</head>

<body>
    @include('header')
    <main>
        <section>
            <div class="container">
                <div class="flex justify-between items-center mb-4">
                    <h1 class="text-2xl font-bold">Pizza Menu</h1>
                    <button onclick="window.location.href='/beheer/pizzas/create'"
                        class="bg-green-500 hover:bg-green-600 text-white py-2 px-4 rounded">Creeër Pizza</button>
                </div>
                <div class="pizza-container">
                    @foreach ($pizzas as $pizza)
                        <div class="pizza-card">
                            <img src="{{ asset($pizza->image) }}" alt="{{ $pizza->name }}">
                            <div class="pizza-details">
                                <h2 class="pizza-name">{{ $pizza->name }}</h2>
                                <p class="pizza-description">{{ $pizza->description }}</p>
                                <p class="pizza-price">€{{ $pizza->price }}</p>
                                <div class="flex space-x-4">
                                    <button onclick="editPizza('{{ $pizza->id }}')"
                                        class="order-button bg-blue-500 hover:bg-blue-600 text-white w-full">Bewerk
                                        pizza</button>
                                    <form action="{{ route('pizza.destroy', ['pizza' => $pizza->id]) }}" method="POST"
                                        class="w-full">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="order-button bg-red-500 hover:bg-red-600 text-white w-full">Verwijder
                                            pizza</button>
                                    </form>
                                </div>
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
            <label for="ingredients" style="margin-bottom: 10px;">Kies ingrediënten:</label>
            <div class="ingredient-checkboxes">
                @foreach ($ingredients as $ingredient)
                    <div class="ingredient-checkbox">
                        <label>{{ $ingredient->name }}</label>
                        <input type="checkbox" name="ingredients[]" id="{{ $ingredient->name }}"
                            value="{{ $ingredient->name }}">
                    </div>
                @endforeach
            </div>

            <label for="pizza-customization">Aanpassingen:</label>
            <input type="text" id="pizza-customization" placeholder="Typ hier de aanpassingen...">
            <button onclick="addtocart(this)">Toevoegen aan winkelwagen</button>
        </section>
    </main>
    @include('footer')

    <script>
        function deletePizza(pizzaId) {
            // Implement AJAX request to delete pizza
            fetch(`/delete-pizza/${pizzaId}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            }).then(response => {
                if (response.ok) {
                    location.reload();
                } else {
                    alert('Failed to delete pizza.');
                }
            });
        }

        function editPizza(pizzaId) {
            window.location.href = `/beheer/pizzas/${pizzaId}/edit`;
        }
    </script>
</body>

</html>
