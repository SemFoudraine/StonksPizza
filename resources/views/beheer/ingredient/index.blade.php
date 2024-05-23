<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ingrediënten</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            font-size: 24px;
            color: #333;
            margin-bottom: 20px;
        }

        form {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input[type="text"] {
            width: calc(100% - 10px);
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        button {
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #0056b3;
        }

        ul {
            list-style-type: none;
            padding: 0;
        }

        li {
            padding: 10px;
            background-color: #f3f3f3;
            border-radius: 5px;
            margin-bottom: 10px;
        }

        form.inline {
            display: inline;
            margin-left: 10px;
        }

        button.edit {
            background-color: #ffc107;
            color: #333;
        }

        button.delete {
            background-color: #dc3545;
            color: #fff;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Ingrediënten</h1>

        <!-- Formulier voor het toevoegen en bewerken van ingrediënten -->
        <form id="ingredientForm" action="{{ isset($editingIngredient) ? route('ingredients.update', $editingIngredient->id) : route('ingredients.store') }}" method="POST">
            @csrf
            @if(isset($editingIngredient))
            @method('PUT')
            @endif

            <label for="name">Naam:</label>
            <input type="text" id="name" name="name" value="{{ isset($editingIngredient) ? $editingIngredient->name : '' }}" required>
            <label for="price">Prijs:</label>
            <input type="number" id="price" name="price" value="{{ isset($editingIngredient) ? $editingIngredient->price : '' }}" step="0.01" required>
            <button type="submit">{{ isset($editingIngredient) ? 'Bijwerken' : 'Toevoegen' }}</button>
            @if(isset($editingIngredient))
            <button type="button" onclick="cancelEdit()">Annuleren</button>
            @endif
        </form>

<ul>
    @foreach ($ingredients as $ingredient)
    <li>
        {{ $ingredient->name }} - €{{ $ingredient->price }}
        <form class="inline" action="{{ route('ingredients.destroy', $ingredient->id) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="delete">Verwijderen</button>
        </form>
        <button type="button" onclick="editIngredient({{ $ingredient }})" class="edit">Bewerken</button>
    </li>
    @endforeach
</ul>

    </div>

    <script>
        function editIngredient(ingredient) {
            document.getElementById('name').value = ingredient.name;
            document.getElementById('ingredientForm').action = '/ingredients/' + ingredient.id;
            document.getElementById('ingredientForm').method = 'POST';
            var methodInput = document.createElement('input');
            methodInput.type = 'hidden';
            methodInput.name = '_method';
            methodInput.value = 'PUT';
            document.getElementById('ingredientForm').appendChild(methodInput);
        }

        function cancelEdit() {
            document.getElementById('name').value = '';
            document.getElementById('ingredientForm').action = '/ingredients';
            document.getElementById('ingredientForm').method = 'POST';
            var methodInput = document.querySelector('input[name="_method"]');
            if (methodInput) {
                methodInput.remove();
            }
        }
    </script>
</body>

</html>
