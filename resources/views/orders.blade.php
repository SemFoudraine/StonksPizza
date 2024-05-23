<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/app.css">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,500,0,0" />
    <script src="js/script.js"></script>
    <title>Document</title>
    <style>
        /* Custom styles for cards */
        .card {
            margin-bottom: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            background-color: #f3f4f6;
            padding: 10px;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
            position: relative;
        }

        .toggle-button {
            position: absolute;
            top: 10px;
            right: 10px;
            cursor: pointer;
        }

        .card-body {
            padding: 20px;
        }

        .container {
            margin-top: 7rem;
        }

        .status-dot {
            display: inline-block;
            width: 10px;
            height: 10px;
            border-radius: 50%;
            margin-right: 5px;
            vertical-align: middle;
        }

        /* Color classes */
        .received {
            background-color: #007bff;
        }

        .preparing {
            background-color: #dc3545;
        }

        .cooking {
            background-color: #ffc107;
        }

        .ready {
            background-color: #52c41a;
        }

        .on-the-way {
            background-color: #17a2b8;
        }

        .delivered {
            background-color: #52c41a;
        }

        .canceled {
            background-color: #EF4444;
        }
    </style>
</head>

<body>
    @include('header')
    <div class="container mx-auto px-4">
        @guest
            <form action="{{ route('orders.index') }}" method="GET" class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">Voer je e-mailadres in om je
                    bestellingen te bekijken:</label>
                <div class="mt-1 flex rounded-md shadow-sm">
                    <input type="email" name="email" id="email"
                        class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-md sm:text-sm border-gray-300"
                        placeholder="jouw-email@example.com">
                    <button type="submit" class="ml-2 px-4 py-2 bg-blue-500 text-white rounded-md">Zoeken</button>
                </div>
            </form>
        @endguest

        @if ($orders->isEmpty())
            @auth
                <p class="text-center text-gray-500">Geen bestellingen gevonden.</p>
            @endauth
        @else
            @foreach ($orders as $order)
                <div class="card mb-4">
                    <div
                        class="card-header bg-gray-200 py-3 {{ $order->status === 'Geannuleerd' ? 'bg-red-500 text-white' : '' }}">
                        <h3 class="text-lg font-semibold">
                            <span
                                class="status-dot
                            @if ($order->status === 'Ontvangen') received
                            @elseif($order->status === 'Wordt bereid') preparing
                            @elseif($order->status === 'In de oven') cooking
                            @elseif($order->status === 'Klaar') ready
                            @elseif($order->status === 'Onderweg') on-the-way
                            @elseif($order->status === 'Bezorgd') delivered
                            @elseif($order->status === 'Geannuleerd') canceled @endif">
                            </span>
                            Bestelling #{{ $order->id }}
                            {{ $order->status === 'Geannuleerd' ? '(Geannuleerd)' : '' }}
                        </h3>
                        @if ($order->status === 'Ontvangen')
                            <form action="{{ route('orders.cancel', $order->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="toggle-button mr-8">Annuleer bestelling</button>
                            </form>
                        @endif
                        <button class="toggle-button" onclick="toggleCardVisibility('cardBody{{ $order->id }}')">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                                </path>
                            </svg>
                        </button>
                    </div>

                    <div id="cardBody{{ $order->id }}"
                        class="card-body grid grid-cols-2 gap-4 {{ $order->status === 'Bezorgd' ? 'hidden' : '' }} {{ $order->status === 'Geannuleerd' ? 'hidden' : '' }}">
                        <div>
                            <p><span id="p-namen" class="font-semibold">Naam:</span> {{ $order->customer_name }}</p>
                            <p><span id="p-namen" class="font-semibold">Email:</span> {{ $order->customer_email }}
                            </p>
                            <p><span id="p-namen" class="font-semibold">Adres:</span> {{ $order->address }}</p>
                        </div>
                        <div>
                            <p><span id="p-namen" class="font-semibold">Totaalprijs:</span>
                                €{{ $order->total_price }}
                            </p>
                            <p><span id="p-namen" class="font-semibold">Besteld op:</span>
                                {{ $order->created_at->format('d-m-Y') }}</p>
                            <p><span id="p-namen" class="font-semibold">Status:</span>
                                <span
                                    class="font-semibold
                                @if ($order->status === 'Ontvangen') text-blue-500
                                @elseif($order->status === 'Wordt bereid') text-red-500
                                @elseif($order->status === 'In de oven') text-yellow-500
                                @elseif($order->status === 'Klaar') text-green-500
                                @elseif($order->status === 'Onderweg') text-orange-500
                                @elseif($order->status === 'Bezorgd') text-green-500
                                @elseif($order->status === 'Geannuleerd') text-red-500 @endif">{{ $order->status }}</span>
                            </p>
                        </div>
                        <hr class="my-4 border-gray-300">
                        <h5 class="text-lg font-semibold flex justify-between items-center">
                            <span>Bestelde Items:</span>
                            <button class="focus:outline-none text-gray-500 hover:text-gray-700"
                                onclick="toggleAllOrderItems('orderItems{{ $order->id }}')">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7">
                                    </path>
                                </svg>
                            </button>
                        </h5>
                        <ul id="orderItems{{ $order->id }}" class="list-disc pl-6 hidden">
                            @foreach ($order->items as $item)
                                <li id="orderItem{{ $item->id }}" class="order-item">
                                    <span>{{ $item->pizza_name }} - {{ $item->quantity }}x</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endforeach
        @endif
    </div>

    <script>
        function toggleAllOrderItems(itemId) {
            const orderItems = document.getElementById(itemId);
            orderItems.classList.toggle('hidden');
        }

        function toggleCardVisibility(cardId) {
            const cardBody = document.getElementById(cardId);
            cardBody.classList.toggle('hidden');
        }
    </script>
</body>

</html>
