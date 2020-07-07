<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="theme-color" content="#45a6b3" />
    <title>Random Dogs</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Varela+Round" rel="stylesheet" type="text/css">
    <link rel="icon" href="/photo.jpg" />
    <!-- Styles -->
    <style>
        body {
            font-family: "Varela Round", sans-serif;
            margin: 0;
            padding: 0;
            background: radial-gradient(#57bfc7, #45a6b3);
        }

        .container {
            display: flex;
            height: 100vh;
            align-items: center;
            justify-content: center;
        }

        .content {
            text-align: center;
        }

        .logo {
            margin-right: 40px;
            margin-bottom: 20px;
        }

        .links a {
            font-size: 1.25rem;
            text-decoration: none;
            color: white;
            margin: 10px;
        }

        @media all and (max-width: 500px) {

            .links {
                display: flex;
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
<div class="container">
    <div class="content">
        <div class="logo text-center" align="center">
            <img src="/photo.jpg" style="border-radius: 100%;" width="200" height="200">
            <h1 class="text-capitalize">Random Dogs</h1>
        </div>
        <div class="links" align="center">
            <a href="https://t.me/random_dogs_php_bot" target="_blank">Telegram</a>
            <a href="https://t.me/LookBig" target="_blank">Developer</a>
        </div>
    </div>
</div>
<script src='https://cdn.jsdelivr.net/npm/botman-web-widget@0/build/js/widget.js'></script>
</body>
</html>