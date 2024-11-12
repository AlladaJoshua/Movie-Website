<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        @font-face {
            font-family: 'Netflix Sans';
            src: url('{{ asset("/Font/NetflixSans-Light.otf") }}') format('opentype');
            font-weight: 300;
            font-style: normal;
        }
    
        @font-face {
            font-family: 'Netflix Sans';
            src: url('{{ asset("/Font/NetflixSans-Regular.otf") }}') format('opentype');
            font-weight: 400;
            font-style: normal;
        }
    
        @font-face {
            font-family: 'Netflix Sans';
            src: url('{{ asset("/Font/NetflixSans-Medium.otf") }}') format('opentype');
            font-weight: 500;
            font-style: normal;
        }
    
        @font-face {
            font-family: 'Netflix Sans';
            src: url('{{ asset("/Font/NetflixSans-Bold.otf") }}') format('opentype');
            font-weight: 700;
            font-style: normal;
        }
    </style>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <!-- Include Navbar Component -->
    <x-navbar />

    {{ $slot }}

    <div id="loader" style="display: none;">
        <div class="spinner"></div>
        <span>Loading...</span>
    </div>

    @vite('resources/js/script.js')
</body>
</html>