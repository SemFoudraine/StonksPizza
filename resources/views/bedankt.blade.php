<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bedankt voor je bestelling</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f3f4f6;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background-color: #ffffff;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            padding: 20px;
            max-width: 400px;
            text-align: center;
        }

        .map-container {
            margin-bottom: 20px;
        }

        .button-container {
            display: flex;
            justify-content: center;
            gap: 10px;
        }

        .button {
            background-color: #4CAF50;
            border: none;
            color: white;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .button:hover {
            background-color: #45a049;
        }

        .payment-method {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 1.7rem;
}

.payment-method img {
    max-width: 65px;
    height: auto;
}

    </style>
</head>

<body>
    <div class="container">
        <div class="map-container">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2485.5400829235423!2d5.494135711715193!3d51.46660011356612!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47c6d8d46a1fd9a7%3A0x2683f0238844f87a!2sSumma%20College!5e0!3m2!1snl!2snl!4v1712739386876!5m2!1snl!2snl"
                style="border:0; width:100%; height:200px;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
        <form action="/bestelling-toevoegen" method="POST">
        <div class="message">
            <h2>Je bestelling wordt zo bezorgd</h2>
            <p>Orient Express heeft bevestigd dat je bestelling snel bezorgd wordt.</p>
        </div>
        <div class="button-container">
            <button class="button" data-tip="5">5% fooi</button>
            <button class="button" data-tip="10">10% fooi</button>
            <button class="button" data-tip="15">15% fooi</button>
        </div>
        <h3>Kies jouw betaalmethode</h3>
        <div class="payment-method">
            <img class="header-img" src="img/paypal.png" alt="logo">
            <img class="header-img" src="img/ideal.png" alt="logo">
            <img class="header-img" src="img/contant.png" alt="logo">
        </div>
        </form>
    </div>
</body>
</html>
