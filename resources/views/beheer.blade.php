<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/app.css">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,500,0,0" />
    <title>Document</title>
</head>

<body class="pt-20 bg-gray-100">
    @include('header')
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <section class="container mx-auto p-10 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Herhaal deze kaart voor elke kaart die je wilt weergeven -->
        @if(auth()->user()->hasRole('medewerker') || auth()->user()->hasRole('manager') || auth()->user()->hasRole('koerier'))
            <div class="max-w-4xl p-7 bg-white border border-gray-200 rounded-lg shadow">
                <a href="/beheer/orders">
                    <h5 class="mb-2 text-2xl font-bold tracking-tight"><i class='bx bxs-receipt mr-3'></i>Bestellingen
                    </h5>
                </a>
                <p class="mb-3 font-normal text-gray-700">Beheer bestellingen, deze functie is beschikbaar voor alle
                    werknemers. </p>
                <a href="/beheer/orders"
                    class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-stonks-groen rounded-lg hover:bg-stonks-groen2 hover:text-white focus:ring-2 focus:outline-none focus:ring-stonks-groen">
                    Beheer
                </a>
            </div>
        @endif

        @if(auth()->user()->hasRole('manager'))
            <div class="max-w-4xl p-7 bg-white border border-gray-200 rounded-lg shadow">
                <a href="werknemers">
                    <h5 class="mb-2 text-2xl font-bold tracking-tight"><i class='bx bxs-user mr-3'></i>Werknemers</h5>
                </a>
                <p class="mb-3 font-normal text-gray-700">Beheer werknemers, deze functie is alleen beschikbaar voor
                    managers. </p>
                <a href="/werknemers"
                    class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-stonks-groen rounded-lg hover:bg-stonks-groen2 hover:text-white focus:ring-2 focus:outline-none focus:ring-stonks-groen">
                    Beheer
                </a>
            </div>
        @endif

        @if(auth()->user()->hasRole('medewerker') || auth()->user()->hasRole('manager'))
        <div class="max-w-4xl p-7 bg-white border border-gray-200 rounded-lg shadow">
            <a href="/beheer/pizzas">
                <h5 class="mb-2 text-2xl font-bold tracking-tight">
                    <i class='bx bxs-pizza bx-flip-horizontal mr-3'></i>Pizza's
                </h5>
            </a>
            <p class="mb-3 font-normal text-gray-700">
                Beheer pizza's, deze functie is alleen beschikbaar voor managers en medewerkers.
            </p>
            <a href="/beheer/pizzas"
                class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-stonks-groen rounded-lg hover:bg-stonks-groen2 hover:text-white focus:ring-2 focus:outline-none focus:ring-stonks-groen">
                Beheer
            </a>
        </div>
        @endif


        @if(auth()->user()->hasRole('medewerker') || auth()->user()->hasRole('manager'))
            <div class="max-w-4xl p-7 bg-white border border-gray-200 rounded-lg shadow">
                <a href="/beheer/ingredient"">
                    <h5 class="mb-2 text-2xl font-bold tracking-tight"><i class='bx bxs-food-menu mr-3'></i>Ingrediënten
                    </h5>
                </a>
                <p class="mb-3 font-normal text-gray-700">Beheer ingrediënten, deze functie is alleen beschikbaar voor
                    managers en medewerkers. </p>
                <a href="/beheer/ingredient"
                    class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-stonks-groen rounded-lg hover:bg-stonks-groen2 hover:text-white focus:ring-2 focus:outline-none focus:ring-stonks-groen">
                    Beheer
                </a>
            </div>
        @endif
    </section>
</body>

</html>
