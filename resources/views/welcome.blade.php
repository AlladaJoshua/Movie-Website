<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    @vite(['resources/js/app.js', 'resources/css/welcome.css'])
    <style>
        /* Ensure the container takes up the full viewport height */
        .container {
            position: relative;
            width: 100%;
            height: 100vh;
            /* Full screen height */
            background-image: url('{{ asset('assets/BG_JacSine.png') }}');
            background-size: cover;
            /* Make sure the image covers the container */
            background-position: center;
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
            /* Text color */
            text-align: center;
        }

        /* Add the dimming effect with an overlay */
        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.8);
            /* Black overlay with 50% opacity */
            z-index: 1;
            /* Place the overlay above the background image */
        }
    </style>

</head>

<body>
    <nav>
        <img src="{{ asset('assets/JacsineWhite.png') }}" alt="">
    </nav>
    <div class="container">
        <div class="overlay"></div>
        <div class="content">
            <div class="img">
                <img src="{{ asset('assets/LP_JacSine.png') }}" alt="Image">
            </div>
            <div class="description">
                <h1>Enjoy Local Movies On-the-Go</h1>
                <p>Download and Connect to JAC Liner Wi-Fi</p>
            </div>
            <div class="cta">
                <button>Download Now</button>
            </div>
        </div>
    </div>
</body>

</html>
