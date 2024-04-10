<header>
    @php
        $inputStyle =
            'width: 100%; padding: 10px; margin-top: 10px; border: 1px solid #ddd; border-radius: 5px; box-sizing: border-box;';
    @endphp
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <a class="header-img-a" href="/"><img class="header-img" src="img/logo_bg.png" alt="logo"></a>
    <div id="header-links" class="header-links">
        <a href="/">Home</a>
        <a href="menu">Menu</a>

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
                <input type="text" name="name" value="{{ auth()->user()->name ?? '' }}"
                    placeholder="Voor- en Achternaam" style="{{ $inputStyle }}">
                <input type="email" name="email" value="{{ auth()->user()->email ?? '' }}" placeholder="Email"
                    style="{{ $inputStyle }}">
                <input type="tel" name="phone" value="{{ auth()->user()->phone ?? '' }}"
                    placeholder="Telefoonnummer" style="{{ $inputStyle }}">
                <input type="text" name="woonplaats" value="{{ auth()->user()->woonplaats ?? '' }}"
                    placeholder="Woonplaats" style="{{ $inputStyle }}">
                <input type="text" name="postcode" value="{{ auth()->user()->postcode ?? '' }}"
                    placeholder="Postcode" style="{{ $inputStyle }}">
                <input type="text" name="adres" value="{{ auth()->user()->adres ?? '' }}"
                    placeholder="Adres + Huisnummer" style="{{ $inputStyle }}">
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
                <div id="total-price"></div>
                <a href="/bedankt"><button class="order-button">Bestel Nu</button></a>
            </div>
        </div>
    </section>
</header>
