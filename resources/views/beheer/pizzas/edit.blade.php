<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,500,0,0" />
    <script src="{{ asset('js/script.js') }}"></script>
    <title>Bewerk Pizza</title>
</head>

<body class="bg-gray-100">
    @include('header')
    <main class="py-8">
        <section class="max-w-4xl mx-auto bg-white p-8 rounded-lg shadow-md">
            <h1 class="text-2xl font-bold mb-6">Bewerk Pizza</h1>
            <form action="{{ route('pizza.update', ['pizza' => $pizza->id]) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label for="name" class="block text-gray-700 font-bold mb-2">Naam:</label>
                    <input type="text" id="name" name="name" value="{{ $pizza->name }}" required
                        class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div class="mb-4">
                    <label for="description" class="block text-gray-700 font-bold mb-2">Beschrijving:</label>
                    <textarea id="description" name="description" required
                        class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">{{ $pizza->description }}</textarea>
                </div>
                <div class="mb-4">
                    <label for="price" class="block text-gray-700 font-bold mb-2">Prijs:</label>
                    <input type="number" id="price" name="price" value="{{ $pizza->price }}" step="0.01"
                        required
                        class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div class="mb-4">
                    <label for="image" class="block text-gray-700 font-bold mb-2">Afbeelding:</label>
                    <input type="file" id="image" name="image"
                        class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none">
                    <img src="{{ asset('img/' . $pizza->image) }}" alt="{{ $pizza->name }}"
                        class="mt-4 w-32 h-32 object-cover">
                </div>
                <div class="mb-4">
                    <label for="ingredients" class="block text-gray-700 font-bold mb-2">Ingrediënten:</label>
                    <div class="grid grid-cols-2 gap-4">
                        @php
                            $selectedIngredients = $pizza->ingredients->pluck('name')->toArray();
                        @endphp
                        @foreach ($ingredients as $ingredient)
                            <div class="flex items-center">
                                <input type="checkbox" id="ingredient-{{ $ingredient->id }}" name="ingredients[]"
                                    value="{{ $ingredient->id }}"
                                    {{ in_array($ingredient->name, $selectedIngredients) ? 'checked' : '' }}
                                    class="mr-2">
                                <label for="ingredient-{{ $ingredient->id }}"
                                    class="text-gray-700">{{ $ingredient->name }}</label>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="flex justify-end space-x-4">
                    <button type="submit"
                        class="px-4 py-2 bg-blue-500 text-white font-bold rounded-md hover:bg-blue-600">Opslaan</button>
                    <a href="/"
                        class="px-4 py-2 bg-gray-500 text-white font-bold rounded-md hover:bg-gray-600">Annuleren</a>
                </div>
            </form>
        </section>
    </main>
    @include('footer')
</body>

</html>
