<header>
     <a class="header-img-a" href="https://stonkspizza.nl/"><img class="header-img" src="img/logo_bg.png" alt="logo"></a>
     <div id="header-links" class="header-links">
          <a href="https://stonkspizza.nl/">Home</a>
          <a href="menu">Menu</a>

          <div onclick="opencartwinkelwagen()" id="open-cart" class="open-cart">
               <a style="display: flex;" class="open-cart"><span class="material-symbols-outlined">shopping_cart</span></a>
               <div id="cartcounter" class="cart-counter">0</div>
          </div>
     </div>
     <div class="header-auth">
          @if (Route::has('login') && Auth::check())
          <a href="{{ url('/dashboard') }}">Dashboard</a>
          @elseif (Route::has('login') && !Auth::check())
          <a href="{{ url('/login') }}">Login</a>
          <a href="{{ url('/register') }}">Register</a>
          @endif
     </div>
</header>