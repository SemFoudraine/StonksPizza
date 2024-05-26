<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/app.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,500,0,0" />
    <script src="js/script.js"></script>
    <title>Document</title>
    <style>
      body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .pizza-container {
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }

        .pizza-card {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .pizza-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-bottom: 1px solid #eee;
        }

        .pizza-details {
            padding: 20px;
        }

        .pizza-name {
            margin-top: 0;
            font-size: 1.5rem;
            font-weight: bold;
            color: #333;
        }

        .pizza-description {
            color: #666;
        }

        .pizza-price {
            font-size: 1.2rem;
            font-weight: bold;
            color: #007bff;
        }

        .order-button {
            display: block;
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            font-size: 1rem;
            color: #fff;
            background-color: #28a745;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .order-button:hover {
            background-color: #218838;
        }

        /* Formuliersectie */
        #editPizzaForm {
            display: none;
            margin-top: 40px;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        #editPizzaForm h2 {
            margin-top: 0;
            margin-bottom: 20px;
            font-size: 2rem;
            color: #333;
        }

        #editPizzaForm label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
            color: #333;
        }

        #editPizzaForm input[type="text"],
        #editPizzaForm input[type="number"],
        #editPizzaForm textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1rem;
            color: #333;
        }

        #editPizzaForm button[type="submit"] {
            padding: 10px 20px;
            font-size: 1rem;
            color: #fff;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        #editPizzaForm button[type="submit"]:hover {
            background-color: #0056b3;
        }
        .delete-button {
        padding: 10px 20px;
        font-size: 1rem;
        color: #fff;
        background-color: #dc3545; /* Rood kleur */
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .delete-button:hover {
        background-color: #c82333; /* Donkerder rood bij hover */
    }
    </style>
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
                            <button onclick="editPizza('{{ $pizza->id }}', '{{ $pizza->name }}', '{{ $pizza->description }}', '{{ $pizza->price }}', '{{ $pizza->calories }}')" class="order-button" data-pizza="{{ $pizza->name }}">Pas nu aan</button>
                            <div class="delete-button">
                                <form method="POST" action="{{ route('pizza.destroy', ['pizza' => $pizza->id]) }}" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Weet je zeker dat je deze pizza wilt verwijderen?')">Verwijder</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>

        <section id="editPizzaForm">
            <h2>Bewerk Pizza</h2>
            <form id="editForm" method="POST" action="">
                @csrf
                @method('PUT')
                <input type="hidden" id="pizzaId" name="pizzaId">
                <label for="pizzaName">Naam:</label>
                <input type="text" id="pizzaName" name="name" required>
                <label for="pizzaDescription">Beschrijving:</label>
                <textarea id="pizzaDescription" name="description" rows="3" required></textarea>
                <label for="pizzaIngredients">Ingrediënten:</label>
                <select id="pizzaIngredients" name="ingredients[]" multiple required>
                    @foreach($ingredients as $ingredient)
                        <option value="{{ $ingredient->id }}">{{ $ingredient->name }}</option>
                    @endforeach
                </select>
                <label for="pizzaPrice">Prijs:</label>
                <input type="number" id="pizzaPrice" name="price" min="0" step="0.01" required>
                <label for="pizzaCalories">Calorieën:</label>
                <input type="number" id="pizzaCalories" name="calories" min="0" step="1">
                <button type="submit">Opslaan</button>
            </form>
        </section>
        <button onclick="toggleAddPizzaForm()" class="order-button" style="margin-bottom: 20px;">Pizza Toevoegen</button>

        <div id="addPizzaForm" style="display: none; background-color: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
            <h2 style="margin-top: 0; margin-bottom: 20px; font-size: 2rem; color: #333;">Pizza Toevoegen</h2>
            <form method="POST" action="{{ route('pizza.store') }}" enctype="multipart/form-data">
                @csrf
                <div style="margin-bottom: 20px;">
                    <label for="name" style="display: block; margin-bottom: 10px; font-weight: bold; color: #333;">Naam:</label>
                    <input type="text" id="name" name="name" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; font-size: 1rem; color: #333;">
                </div>
                <div style="margin-bottom: 20px;">
                    <label for="description" style="display: block; margin-bottom: 10px; font-weight: bold; color: #333;">Beschrijving:</label>
                    <textarea id="description" name="description" rows="3" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; font-size: 1rem; color: #333;"></textarea>
                </div>
                <div>
                    <label for="ingredients">Ingrediënten:</label>
                    <select name="ingredients[]" id="ingredients" multiple required>
                        @foreach($ingredients as $ingredient)
                            <option value="{{ $ingredient->id }}">{{ $ingredient->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div style="margin-bottom: 20px;">
                    <label for="price" style="display: block; margin-bottom: 10px; font-weight: bold; color: #333;">Prijs:</label>
                    <input type="number" id="price" name="price" min="0" step="0.01" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; font-size: 1rem; color: #333;">
                </div>
                <div style="margin-bottom: 20px;">
                    <label for="calories" style="display: block; margin-bottom: 10px; font-weight: bold; color: #333;">Calorieën:</label>
                    <input type="number" id="calories" name="calories" min="0" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; font-size: 1rem; color: #333;">
                </div>
                <div style="margin-bottom: 20px;">
                    <label for="image" style="display: block; margin-bottom: 10px; font-weight: bold; color: #333;">Afbeelding:</label>
                    <input type="file" id="image" name="image" accept="image/*" required style="padding: 10px; border: 1px solid #ccc; border-radius: 5px; font-size: 1rem; color: #333;">
                </div>
                <button type="submit" style="padding: 10px 20px; font-size: 1rem; color: #fff; background-color: #007bff; border: none; border-radius: 5px; cursor: pointer; transition: background-color 0.3s;">Toevoegen</button>
            </form>
        </div>

    </main>
    @include('footer')

    <script>
        function toggleAddPizzaForm() {
            var addPizzaForm = document.getElementById('addPizzaForm');
            addPizzaForm.style.display = addPizzaForm.style.display === 'none' || addPizzaForm.style.display === '' ? 'block' : 'none';
        }

        function editPizza(id, name, description, price, calories) {
            document.getElementById('pizzaId').value = id;
            document.getElementById('pizzaName').value = name;
            document.getElementById('pizzaDescription').value = description;
            document.getElementById('pizzaPrice').value = price;
            document.getElementById('pizzaCalories').value = calories;

            document.getElementById('editForm').setAttribute('action', '/beheer/pizzas/' + id);
            document.getElementById('editPizzaForm').style.display = 'block';
        }
    </script>
</body>

</html>
