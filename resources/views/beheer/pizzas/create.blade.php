<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,500,0,0" />
    <title>Create Pizza</title>
</head>

<body class="flex flex-col min-h-screen">
    @include('header')
    <main class="flex-grow">
        <section class="flex justify-center items-center min-h-full bg-gray-100">
            <div class="container max-w-lg mx-auto mt-10 p-6 bg-white shadow-md rounded-lg">
                <h1 class="text-3xl font-bold mb-6 text-center">Creeër Nieuwe Pizza</h1>
                <form action="{{ route('pizza.store') }}" method="POST" enctype="multipart/form-data"
                    class="space-y-4">
                    @csrf
                    <div>
                        <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Pizza Naam:</label>
                        <input type="text" id="name" name="name"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            required>
                    </div>
                    <div>
                        <label for="description"
                            class="block text-gray-700 text-sm font-bold mb-2">Beschrijving:</label>
                        <textarea id="description" name="description"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            required></textarea>
                    </div>
                    <div>
                        <label for="price" class="block text-gray-700 text-sm font-bold mb-2">Prijs (€):</label>
                        <input type="number" id="price" name="price" step="0.01"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            required>
                    </div>
                    <div>
                        <label for="image" class="block text-gray-700 text-sm font-bold mb-2">Afbeelding:</label>
                        <input type="file" id="image" name="image"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            required>
                    </div>
                    <div>
                        <label for="ingredients"
                            class="block text-gray-700 text-sm font-bold mb-2">Ingrediënten:</label>
                        <select id="ingredients" name="ingredients[]" multiple
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            required>
                            @foreach ($ingredients as $ingredient)
                                <option value="{{ $ingredient->id }}">{{ $ingredient->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex items-center justify-between">
                        <button type="submit"
                            class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Opslaan</button>
                        <a href="{{ route('pizza.index') }}"
                            class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">Annuleren</a>
                    </div>
                </form>
            </div>
        </section>
    </main>
    @include('footer')
</body>

</html>
