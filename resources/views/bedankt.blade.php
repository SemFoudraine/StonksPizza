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
            <iframe id="googleMap" style="border:0; width:100%; height:200px;" allowfullscreen="" loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>

        <div class="message">
            <h2>Je bestelling is ontvangen</h2>
            <p>Dit is enkel een bevestiging dat de bestelling is ontvangen.</p>
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

        <h1>Bedankt voor je bestelling!</h1>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                function updateMap() {
                    const latitude = sessionStorage.getItem('latitude');
                    const longitude = sessionStorage.getItem('longitude');

                    console.log('Nieuwe breedtegraad in sessionStorage:', sessionStorage.getItem('latitude'));
                    console.log('Nieuwe lengtegraad in sessionStorage:', sessionStorage.getItem('longitude'));

                    // Controleer of latitude en longitude gedefinieerd zijn voordat je de kaart bijwerkt
                    if (latitude && longitude) {
                        console.log("Attempting to update map with:", latitude, longitude);
                        const apiKey = 'AIzaSyCcUU_2IudJMubc2UQW1yu9-HkWFy0u22c';
                        const zoomLevel = 17;

                        const iframeUrl =
                            `https://www.google.com/maps/embed/v1/view?key=${apiKey}&center=${latitude},${longitude}&zoom=${zoomLevel}`;
                        document.getElementById('googleMap').src = iframeUrl;
                    } else {
                        console.error("Latitude or longitude is not defined in sessionStorage.");
                    }
                }

                updateMap(); // Roep de updateMap-functie aan bij het laden van de pagina
            });
        </script>
</body>

</html>
