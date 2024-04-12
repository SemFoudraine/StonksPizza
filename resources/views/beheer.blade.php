<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/app.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,500,0,0" />
    <title>Document</title>
</head>

<body class="pt-20 bg-gray-100">
    @include('header')
    @vite(['resources/css/app.css','resources/js/app.js'])

    <section class="container mx-auto p-10 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Herhaal deze kaart voor elke kaart die je wilt weergeven -->
        <div class="max-w-4xl p-7 bg-white border border-gray-200 rounded-lg shadow">
            <a href="#">
                <h5 class="mb-2 text-2xl font-bold tracking-tight">Bestellingen</h5>
            </a>
            <p class="mb-3 font-normal text-gray-700">Beheer bestellingen, deze functie is beschikbaar voor alle werknemers. </p>
            <a href="#" class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-stonks-groen rounded-lg hover:bg-stonks-groen2 hover:text-white focus:ring-4 focus:outline-none focus:ring-blue-300">
                Read more
                <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
                </svg>
            </a>
        </div>

        <div class="max-w-4xl p-7 bg-white border border-gray-200 rounded-lg shadow">
            <a href="#">
                <h5 class="mb-2 text-2xl font-bold tracking-tight">Werknemers</h5>
            </a>
            <p class="mb-3 font-normal text-gray-700">Beheer werknemers, deze functie is alleen beschikbaar voor managers. </p>
            <a href="#" class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-stonks-groen rounded-lg hover:bg-stonks-groen2 hover:text-white focus:ring-4 focus:outline-none focus:ring-blue-300">
                Read more
                <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
                </svg>
            </a>
        </div>

        <div class="max-w-4xl p-7 bg-white border border-gray-200 rounded-lg shadow">
            <a href="#">
                <h5 class="mb-2 text-2xl font-bold tracking-tight">Pizza's</h5>
            </a>
            <p class="mb-3 font-normal text-gray-700">Beheer pizza's, deze functie is alleen beschikbaar voor managers en medewerkers. </p>
            <a href="#" class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-stonks-groen rounded-lg hover:bg-stonks-groen2 hover:text-white focus:ring-4 focus:outline-none focus:ring-blue-300">
                Read more
                <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
                </svg>
            </a>
        </div>

        <div class="max-w-4xl p-7 bg-white border border-gray-200 rounded-lg shadow">
            <a href="#">
                <h5 class="mb-2 text-2xl font-bold tracking-tight">Ingrediënten</h5>
            </a>
            <p class="mb-3 font-normal text-gray-700">Beheer ingrediënten, deze functie is alleen beschikbaar voor managers en medewerkers. </p>
            <a href="#" class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-stonks-groen rounded-lg hover:bg-stonks-groen2 hover:text-white focus:ring-4 focus:outline-none focus:ring-blue-300">
                Read more
                <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
                </svg>
            </a>
        </div>
    </section>
</body>

</html>
