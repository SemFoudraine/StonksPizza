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
        body::after {
            content: "";
            display: block;
            height: 1rem;
        }

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
                            @elseif($order->status === 'Geannuleerd') canceled @endif"></span>
                        Bestelling #{{ $order->id }} {{ $order->status === 'Geannuleerd' ? '(Geannuleerd)' : '' }}
                    </h3>
                    <button class="toggle-button" onclick="toggleOrderVisibility('order{{ $order->id }}')"> <svg
                            class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                            </path>
                        </svg></button>
                </div>
                <div id="order{{ $order->id }}"
                    class="{{ $order->status === 'Bezorgd' ? 'hidden' : '' }} {{ $order->status === 'Geannuleerd' ? 'hidden' : '' }}">
                    <div id="cardBody{{ $order->id }}" class="card-body grid grid-cols-2 gap-4 ">
                        <div>
                            <p><span id="p-namen" class="font-semibold">Naam:</span> {{ $order->customer_name }}</p>
                            <p><span id="p-namen" class="font-semibold">Email:</span> {{ $order->customer_email }}</p>
                            <p><span id="p-namen" class="font-semibold">Adres:</span> {{ $order->address }}</p>
                        </div>
                        <div>
                            <p><span id="p-namen" class="font-semibold">Totaalprijs:</span>
                                €{{ $order->total_price }}
                            </p>
                            <p><span id="p-namen" class="font-semibold">Besteld op:</span>
                                {{ $order->created_at->format('d-m-Y H:i:s') }}</p>
                            @if (
                                $order->status === 'Ontvangen' ||
                                    $order->status === 'Wordt bereid' ||
                                    $order->status === 'In de oven' ||
                                    $order->status === 'Klaar' ||
                                    $order->status === 'Onderweg')
                                <form action="{{ route('orders.update.status', $order->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <label for="status" class="font-semibold">Status:</label>
                                    <select name="status" onchange="this.form.submit()">
                                        @if (auth()->user()->hasRole('koerier'))
                                            <option value="status">Status</option>
                                        @endif
                                        @if (auth()->user()->hasRole('medewerker') || auth()->user()->hasRole('manager'))
                                            <option value="Ontvangen"
                                                {{ $order->status == 'Ontvangen' ? 'selected' : '' }}>
                                                Ontvangen</option>
                                            <option value="Wordt bereid"
                                                {{ $order->status == 'Wordt bereid' ? 'selected' : '' }}>
                                                Wordt bereid</option>
                                            <option value="In de oven"
                                                {{ $order->status == 'In de oven' ? 'selected' : '' }}>
                                                In
                                                de
                                                oven</option>
                                        @endif
                                        @if (auth()->user()->hasRole('medewerker') || auth()->user()->hasRole('manager') || auth()->user()->hasRole('koerier'))
                                            <option value="Onderweg"
                                                {{ $order->status == 'Onderweg' ? 'selected' : '' }}>
                                                Onderweg
                                            </option>
                                            <option value="Bezorgd"
                                                {{ $order->status == 'Bezorgd' ? 'selected' : '' }}>
                                                Bezorgd
                                            </option>
                                        @endif
                                        @if (auth()->user()->hasRole('medewerker') || auth()->user()->hasRole('manager'))
                                            <option value="Geannuleerd"
                                                {{ $order->status == 'Geannuleerd' ? 'selected' : '' }}>
                                                Geannuleerd
                                            </option>
                                        @endif
                                    </select>
                                </form>
                            @endif
                            <p><span id="p-namen" class="font-semibold">Status:</span>
                                <span
                                    class="font-semibold
                                @if ($order->status === 'Ontvangen') text-blue-500
                                @elseif($order->status === 'Wordt bereid') text-red-500
                                @elseif($order->status === 'In de oven') text-yellow-500
                                @elseif($order->status === 'Klaar') text-green-500
                                @elseif($order->status === 'Onderweg') text-blue-400
                                @elseif($order->status === 'Bezorgd') text-green-500
                                @elseif($order->status === 'Geannuleerd') text-red-500 @endif">{{ $order->status }}</span>
                            </p>
                        </div>
                    </div>
                    <hr class="my-5 border-gray-300 ml-6 mr-6">
                    <h5 class="text-lg font-semibold flex justify-between items-center pb-4 ml-4">
                        <span>Bestelde Items:</span>
                        <button class="focus:outine-none text-gray-500 hover:text-gray-700 mr-5"
                            onclick="toggleAllOrderItems('orderItems{{ $order->id }}')">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                                </path>
                            </svg>
                        </button>
                    </h5>
                    <ul id="orderItems{{ $order->id }}" class="list-disc pl-6 hidden pb-4 ml-4">
                        @foreach ($order->items as $item)
                            <li id="orderItem{{ $item->id }}" class="order-item">
                                <span>{{ $item->pizza_name }} - {{ $item->quantity }}x</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endforeach
    </div>

    <script>
        function toggleAllOrderItems(itemId) {
            const orderItems = document.getElementById(itemId);
            orderItems.classList.toggle('hidden');
        }

        // function toggleCardVisibility(cardId) {
        //     const cardBody = document.getElementById(cardId);
        //     cardBody.classList.toggle('hidden');
        // }

        function toggleOrderVisibility(orderId) {
            const order = document.getElementById(orderId);
            order.classList.toggle('hidden');
        }
    </script>
</body>

</html>
