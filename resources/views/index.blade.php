<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/app.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,500,0,0" />
    <script src="js/script.js"></script>
    <title>Document</title>
</head>

<body>
    @include('header')
    <main>
        <section class="carousel">
            <img id="carouselimg" src="img/home-1.png" alt="Foto">
        </section>
        <section class="start">
            <h1>Bestel Online</h1>
            <a href="menu"><span class="material-symbols-outlined">local_shipping</span><span>Direct bestllen</span></a>
        </section>
        <section class="cards">
            <div onclick="cardclicked()">
                <img src="img/stay.jpg" alt="">
                <div>
                    <h1>Mis nooit meer een deal!</h1>
                    <p>Nooit meer een exclusieve deal missen?<br> Meld je dan nu aan en bespaar op jouw favoriete producten.</p>
                </div>
            </div>
            <div onclick="cardclicked()">
                <img src="img/beste.jpg" alt="">
                <div>
                    <h1>Beste ingrediënten</h1>
                    <p>Elke dag weer vers, zorgvuldig voor jou geselecteerd!</p>
                </div>
            </div>
            <div onclick="cardclicked()">
                <img src="img/kom.jpg" alt="">
                <div>
                    <h1>Kom bij ons werken</h1>
                    <p>Op zoek naar een uitdaging?<br> Stuur ons je sollicitatiebrief!</p>
                </div>
            </div>
        </section>
        @include('footer')
    </main>
</body>
</html>
