<header>
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
            <a href="{{ url('/register') }}">Register</a>
        @endif
    </div>

    <section id="cart-popup" class="shopping-cart">
        <div class="cart">
            <h1>Bestelling</h1>
            <ul id="cart-items"></ul>
        </div>
        <div class="contact-info">
            <h1>Contact Info</h1>

            <button id="closecart" onclick="closecart()">Sluiten</button>
        </div>
        <div class="summary">
            <h1>Summary</h1>
            <div>
                <div id="summary-items"></div>
                <div id="total-price"></div>
               <a href="/bedankt"><button class="order-button" >Bestel Nu</button></a>
            </div>
        </div>
    </section>
</header>
