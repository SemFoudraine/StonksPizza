<header>
    @php
        $inputStyle =
            'width: 100%; padding: 10px; margin-top: 10px; border: 1px solid #ddd; border-radius: 5px; box-sizing: border-box;';
    @endphp

    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <a class="header-img-a" href="/"><img class="header-img" src="img/logo_bg.png" alt="logo"></a>
    <div id="header-links" class="header-links">
        {{-- Login --}}
        <a href="/">Home</a>
        <a href="menu">Menu</a>
        @auth
            @php
                $user = Auth::user();
            @endphp
            @if ($user->hasRole('medewerker') || $user->hasRole('manager') || $user->hasRole('koerier'))
                <a href="/beheer">Beheer</a>
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
            <a href="{{ url('/login') }}">Login</a>
            <a href="{{ url('/register') }}">Registreer</a>
        @endif
    </div>

    <section id="cart-popup" class="shopping-cart">
        <div class="cart">
            <h1>Bestelling</h1>
            <ul id="cart-items"></ul>
        </div>
        <div class="contact-info"
            style="background-color: white; padding: 20px; border-radius: 10px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
            <h1 style="font-size: 24px; font-weight: bold; margin-bottom: 20px;">Contact Informatie</h1>
            <form>
                <input type="text" id="name" name="name" value="{{ auth()->user()->name ?? '' }}"
                    placeholder="Voor- en Achternaam" style="{{ $inputStyle }}">
                <input type="email" id="email" name="email" value="{{ auth()->user()->email ?? '' }}"
                    placeholder="Email" style="{{ $inputStyle }}">
                <input type="tel" id="phone" name="phone" value="{{ auth()->user()->phone ?? '' }}"
                    placeholder="Telefoonnummer" style="{{ $inputStyle }}">
                <input type="text" id="zip_code" name="zip_code" value="{{ auth()->user()->postcode ?? '' }}"
                    placeholder="Postcode" style="{{ $inputStyle }}" onchange="fetchAddress()">
                <input type="text" id="house_number" name="house_number"
                    value="{{ auth()->user()->huisnummer ?? '' }}" placeholder="Huisnummer"
                    style="{{ $inputStyle }}" onchange="fetchAddress()">
                <input type="text" id="city" name="city" value="{{ auth()->user()->woonplaats ?? '' }}"
                    placeholder="Woonplaats" style="{{ $inputStyle }}">
                <input type="text" id="street" name="street" value="{{ auth()->user()->adres ?? '' }}"
                    placeholder="Straatnaam" style="{{ $inputStyle }}">
            </form>
            @guest
                <p style="margin-top: 20px;">Je bent niet ingelogd. <a href="{{ route('login') }}"
                        style="color: #007bff; text-decoration: none;">Log in</a> of <a href="{{ route('register') }}"
                        style="color: #007bff; text-decoration: none;">registreer</a> om makkelijker te bestellen.</p>
            @endguest

            <button id="closecart" onclick="closecart()">Sluiten</button>
        </div>
        <div class="summary">
            <h1>Summary</h1>
            <div>
                <div id="summary-items"></div>
                <div class="test" style="position: fixed; margin-top: 8rem;">
                    <p id="total-price"></p>
                    <a href="/bedankt"><button class="order-button">Bestel Nu</button></a>
                </div>
            </div>
        </div>
    </section>
</header>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const postcodeField = document.getElementById('zip_code');
        const huisnummerField = document.getElementById('house_number');

        function fetchAddress() {
            const postcode = postcodeField.value.trim();
            const huisnummer = huisnummerField.value.trim();

            if (!postcode || !huisnummer) {
                console.error('Postcode en huisnummer moeten ingevuld zijn.');
                return; // Doe niets als postcode of huisnummer leeg is
            }

            fetch(`/api/fetch-address?postcode=${postcode}&number=${huisnummer}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Netwerkrespons was niet ok.');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.error) {
                        console.error('Fout bij het ophalen van de gegevens:', data.error);
                        return;
                    }
                    // Update de velden met de opgehaalde data
                    document.getElementById('street').value = data.street || '';
                    document.getElementById('city').value = data.city || '';
                    document.getElementById('zip_code').value = postcode; // Postcode is al bekend
                    document.getElementById('house_number').value = huisnummer; // Huisnummer is al bekend
                    // Indien nodig, update ook latitude, longitude, en provincie velden
                    document.getElementById('latitude').value = data.latitude || '';
                    document.getElementById('longitude').value = data.longitude || '';
                    document.getElementById('province').value = data.province || '';
                })
                .catch(error => {
                    console.error('Fout bij het ophalen van adres:', error);
                });
        }

        // Event listeners voor het ophalen van adres bij wijziging
        postcodeField.addEventListener('input', fetchAddress);
        huisnummerField.addEventListener('input', fetchAddress);
    });
</script>
