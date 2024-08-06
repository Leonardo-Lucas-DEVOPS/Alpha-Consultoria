<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alpha Consultoria</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .bg-image {
            background-image: url('/images/Background.png');
            background-size: cover;
            background-position: center;
            height: 100vh;
        }

        .navbar-brand img {
            height: 40px;
        }

        .btn-custom,
        .btn-outline-custom {
            color: #fff;
            border: 2px solid transparent;
            border-radius: 30px;
            padding: 10px 20px;
            font-weight: bold;
            text-transform: uppercase;
            transition: all 0.3s ease-in-out;
        }

        .btn-custom {
            background-color: #ffc107; /* Amarelo */
            color: #212222; /* Preto */
        }

        .btn-outline-custom {
            color: #ffc107; /* Amarelo */
            background-color: transparent;
            border-color: #ffc107; /* Amarelo */
        }

        .btn-custom:hover,
        .btn-outline-custom:hover {
            background-color: #212222; /* Preto */
            color: #ffc107; /* Amarelo */
            border-color: #ffc107; /* Amarelo */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
        }
    </style>
</head>

<body>
    <div class="bg-image">
        <nav class="navbar navbar-expand-lg navbar-custom">
            <a class="navbar-brand" href="#">
                <img src="/images/logo.png" alt="Logo Alpha Consultoria">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    @if (Route::has('login'))
                        @auth
                            <li class="nav-item">
                                <a class="btn btn-outline-custom" href="{{ url('/dashboard') }}">Dashboard</a>
                            </li>
                        @else
                            <li class="nav-item">
                                <a class="btn btn-outline-custom mr-2" href="{{ route('login') }}">Log in</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="btn btn-custom" href="{{ route('register') }}">Register</a>
                                </li>
                            @endif
                        @endauth
                    @endif
                </ul>
            </div>
        </nav>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.amazonaws.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
