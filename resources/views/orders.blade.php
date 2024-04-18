<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/app.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,500,0,0" />
    <script src="js/script.js"></script>
    <title>Document</title>
    <style>
        /* Aangepaste stijlen voor kaarten */
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
        }

        .card-body {
            padding: 20px;
        }

        .card-body p {
            margin-bottom: 10px;
        }

        .card-body ul {
            margin-top: 10px;
            padding-left: 20px;
        }

        .card-body ul li {
            list-style-type: none;
            margin-bottom: 5px;
        }

        /* Aangepaste stijl voor de container */
        .container {
            margin-top: 7rem; /* Hiermee wordt de ruimte tussen de header en de kaarten vergroot */
        }
    </style>
</head>

@include('header')
<div class="container mx-auto px-4">
    @foreach($orders as $order)
    <div class="card mb-4">
        <div class="card-header bg-gray-200 py-3">
            <h3 class="text-lg font-semibold">Bestelling #{{ $order->id }}</h3>
        </div>
        <div class="card-body">
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <p><span class="font-semibold">Naam:</span> {{ $order->customer_name }}</p>
                    <p><span class="font-semibold">Email:</span> {{ $order->customer_email }}</p>
                    <p><span class="font-semibold">Adres:</span> {{ $order->address }}</p>
                </div>
                <div>
                    <p><span class="font-semibold">Totaalprijs:</span> €{{ $order->total_price }}</p>
                    <p><span class="font-semibold">Besteld op:</span> {{ $order->created_at->format('d-m-Y H:i:s') }}</p>
                </div>
            </div>
            <hr class="my-4 border-gray-300">
            <h5 class="text-lg font-semibold flex justify-between items-center">
                <span>Bestelde Items:</span>
                <button class="focus:outline-none text-gray-500 hover:text-gray-700" onclick="toggleAllOrderItems('orderItems{{ $order->id }}')">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </button>
            </h5>
            <ul id="orderItems{{ $order->id }}" class="list-disc pl-6 hidden">
                @foreach($order->items as $item)
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
</script>
