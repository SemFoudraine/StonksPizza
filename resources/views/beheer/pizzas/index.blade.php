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
            display: grid;
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
        #add-pizza-section {
            margin-top: 40px;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        #add-pizza-section h2 {
            margin-top: 0;
            margin-bottom: 20px;
            font-size: 2rem;
            color: #333;
        }

        #add-pizza-section label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
            color: #333;
        }

        #add-pizza-section input[type="text"],
        #add-pizza-section input[type="number"],
        #add-pizza-section textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1rem;
            color: #333;
        }

        #add-pizza-section button[type="submit"] {
            padding: 10px 20px;
            font-size: 1rem;
            color: #fff;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        #add-pizza-section button[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    @include('header')
    <main>
        <section>
            <div class="container">
                <h2>Pizza's</h2>
                <div class="pizza-container">
                    @foreach ($pizzas as $pizza)
                    <div class="pizza-card">
                        <img src="img/{{ $pizza->image }}" alt="{{ $pizza->name }}">
                        <div class="pizza-details">
                            <h3 class="pizza-name">{{ $pizza->name }}</h3>
                            <p class="pizza-description">{{ $pizza->description }}</p>
                            <p class="pizza-price">${{ $pizza->price }}</p>
                            <button onclick="addToCart(this)" class="order-button" data-pizza="{{ $pizza->name }}">Bestel Nu</button>
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
