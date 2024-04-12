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
            <div class="p-10 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                @foreach (range(1, 5) as $i)
                <div class="bg-white rounded-lg shadow-lg p-5">
                    <img class="w-full h-48 object-cover rounded-md" src="https://via.placeholder.com/150">
                    <div class="mt-4">
                        <h3 class="text-lg font-bold">Card Title {{ $i }}</h3>
                        <p class="text-sm text-gray-600">Card description goes here and can be longer than this.</p>
                        <a href="/link{{ $i }}" class="inline-block mt-4 bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-700 transition-colors">Go to Link {{ $i }}</a>
                    </div>
                </div>
                @endforeach
            </div>
        </section>
    </main>
</body>

</html>
