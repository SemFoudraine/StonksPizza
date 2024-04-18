<header>
    @php
        $inputStyle =
            'width: 100%; padding: 10px; margin-top: 10px; border: 1px solid #ddd; border-radius: 5px; box-sizing: border-box;';
    @endphp

    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script src="js/script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.0.1/dist/tailwind.min.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <a class="header-img-a" href="/"><img class="header-img" src="img/logo_bg.png" alt="logo"></a>
    <div id="header-links" class="header-links">
        {{-- Login --}}
        <a href="/">Home</a>
        <a href="{{ route('menu') }}">Menu</a>
        @auth
            @php
                $user = Auth::user();
            @endphp
            @if ($user->hasRole('medewerker') || $user->hasRole('manager') || $user->hasRole('koerier'))
                <a href="{{ route('beheer') }}">Beheer</a>
            @endif
        @endauth

        <div onclick="opencartwinkelwagen()" id="open-cart" class="open-cart">
            <a style="display: flex;" class="open-cart"><span class="material-symbols-outlined">shopping_cart</span></a>
            <div id="cartcounter" class="cart-counter">0</div>
        </div>
    </div>
    <div class="header-auth">
        @if (Route::has('login') && Auth::check())
            <i class='bx bxs-user'></i><a href="{{ url('/dashboard') }}">{{ Auth::user()->name }}</a>
        @elseif (Route::has('login') && !Auth::check())
            <a href="{{ route('login') }}">Login</a>
            <a href="{{ route('register') }}">Registreer</a>
        @endif
    </div>

    <section id="cart-popup" class="shopping-cart bg-white p-4 rounded-lg shadow-md">
        <div class="cart">
            <h1 class="text-lg font-bold mb-4">Bestelling</h1>
            <ul id="cart-items"></ul>
        </div>
        <div class="contact-info">
            <h1 class="text-lg font-bold mb-4">Contact Informatie</h1>
            <form id="order-form" onsubmit="return submitOrder();">
                @csrf
                <input type="text" id="name" name="name" value="{{ auth()->user()->name ?? '' }}" required
                    placeholder="Voor- en Achternaam" class="mb-2 p-2 border rounded" style="{{ $inputStyle }}">
                <input type="email" id="email" name="email" value="{{ auth()->user()->email ?? '' }}" required
                    placeholder="Email" class="mb-2 p-2 border rounded" style="{{ $inputStyle }}">
                <input type="tel" id="phone" name="phone" value="{{ auth()->user()->phone ?? '' }}" required
                    placeholder="Telefoonnummer" class="mb-2 p-2 border rounded" style="{{ $inputStyle }}">
                <input type="text" id="zip_code" name="zip_code" value="{{ auth()->user()->postcode ?? '' }}"
                    required placeholder="Postcode" class="mb-2 p-2 border rounded" style="{{ $inputStyle }}">
                <input type="text" id="house_number" name="house_number"
                    value="{{ auth()->user()->huisnummer ?? '' }}" required placeholder="Huisnummer"
                    class="mb-2 p-2 border rounded" style="{{ $inputStyle }}">
                <input type="text" id="city" name="city" value="{{ auth()->user()->woonplaats ?? '' }}"
                    required placeholder="Woonplaats" class="mb-2 p-2 border rounded" style="{{ $inputStyle }}">
                <input type="text" id="street" name="street" value="{{ auth()->user()->adres ?? '' }}" required
                    placeholder="Straatnaam" class="mb-2 p-2 border rounded" style="{{ $inputStyle }}">
                <input type="hidden" id="latitude" value="">
                <input type="hidden" id="longitude" value="">
        </div>
        <div class="summary">
            <h1 class="text-lg font-bold mb-4">Samenvatting</h1>
            <div>
                <div id="summary-items"></div>
                <div class="fixed mt-32">
                    <p id="total-price" class="mb-4"></p>
                    <button type="submit"
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out shadow-md hover:shadow-lg active:bg-blue-800 focus:outline-none">
                        Bestellen
                    </button>
                </div>
            </div>
            </form>
            <button id="closecart" onclick="closecart()">Sluiten</button>
        </div>

    </section>
</header>

<script>
    function fetchAddress() {
        const postcodeField = document.getElementById('zip_code');
        const huisnummerField = document.getElementById('house_number');
        const streetField = document.getElementById('street');
        const cityField = document.getElementById('city');

        const postcode = postcodeField.value.trim();
        const huisnummer = huisnummerField.value.trim();

        if (!postcode || !huisnummer) {
            console.error('Postcode en huisnummer moeten ingevuld zijn.');
            return;
        }

        fetch(`/api/fetch-address?postcode=${postcode}&number=${huisnummer}`)
            .then(response => response.json())
            .then(data => {
                console.log('Ontvangen adresgegevens:', data);
                if (data.error) {
                    console.error('Fout bij het ophalen van de gegevens:', data.error);
                    return;
                }
                streetField.value = data.street || '';
                cityField.value = data.city || '';
                document.getElementById('latitude').value = data.latitude;
                document.getElementById('longitude').value = data.longitude;

                console.log('Nieuwe breedtegraad:', data.latitude);
                console.log('Nieuwe lengtegraad:', data.longitude);

                sessionStorage.setItem('latitude', data.latitude);
                sessionStorage.setItem('longitude', data.longitude);

                updateMap(data.latitude, data.longitude);
            })
            .catch(error => {
                console.error('Fout bij het ophalen van adres:', error);
            });
    }

    function updateMap(latitude, longitude) {
        console.log("Updating map to:", latitude, longitude);

        if (!latitude || !longitude) {
            console.error("Latitude or longitude is undefined or incorrect.");
            return;
        }
        var apiKey = 'AIzaSyCcUU_2IudJMubc2UQW1yu9-HkWFy0u22c';
        var zoomLevel = 15;

        var iframeUrl =
            `https://www.google.com/maps/embed/v1/view?key=${apiKey}&center=${latitude},${longitude}&zoom=${zoomLevel}`;
        document.getElementById('googleMap').src = iframeUrl;
    }

    document.addEventListener('DOMContentLoaded', function() {
        const postcodeField = document.getElementById('zip_code');
        const huisnummerField = document.getElementById('house_number');

        postcodeField.addEventListener('input', fetchAddress);
        huisnummerField.addEventListener('input', fetchAddress);
    });

    function submitOrder() {
        event.preventDefault();

        // Haal eerst de adresgegevens op
        fetchAddress();

        const cart = JSON.parse(sessionStorage.getItem("cart")) || [];
        const total = cart.reduce((acc, item) => acc + item.price * item.quantity, 0);

        const formData = new FormData(document.getElementById('order-form'));
        formData.append('cart', JSON.stringify(cart));
        formData.append('total_price', total);

        axios.post('/orders', formData, {
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'multipart/form-data'
                }
            })
            .then(function(response) {
                console.log(response.data); // Log server response

                // Get the new coordinates from the form
                const latitude = document.getElementById('latitude').value;
                const longitude = document.getElementById('longitude').value;

                // Update session with new coordinates before redirecting to thank you page
                sessionStorage.setItem('latitude', latitude);
                sessionStorage.setItem('longitude', longitude);

                // Leeg de winkelwagen
                sessionStorage.removeItem("cart");
                updateCartDisplay
            (); // Zorg ervoor dat de UI ook geüpdatet wordt om de lege winkelwagen te reflecteren

                window.location.href = '/bedankt'; // Redirect to the thank you page
            })
            .catch(function(error) {
                alert('Er is een fout opgetreden bij het plaatsen van de bestelling');
                console.error(error);
            });
        return false; // Voorkom dat het formulier op de traditionele manier wordt ingediend
    }
</script>
