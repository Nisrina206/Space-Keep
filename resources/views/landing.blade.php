<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>SMK Negeri 4 Bojonegoro</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', sans-serif;
        }

        body {
            height: 100vh;
            background: url('{{ asset("img/fotosekolah.png") }}') no-repeat center center/cover;
            position: relative;
            color: white;
        }

        body::after {
            content: "";
            position: absolute;
            inset: 0;
            background: rgba(0,0,0,0.6);
        }

        .container {
            position: relative;
            z-index: 2;
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        /* Navbar */
        .navbar {
            display: flex;
            justify-content: space-between;
            padding: 20px 50px;
            align-items: center;
        }

        .navbar a {
            color: white;
            text-decoration: none;
            margin-left: 25px;
        }

        .login-btn {
            background: linear-gradient(90deg, #00c6ff, #0072ff);
            padding: 8px 20px;
            border-radius: 20px;
        }

        /* Hero */
        .hero {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
        }

        .hero h1 {
            font-size: 60px;
            font-weight: bold;
        }

        .hero h2 {
            color: #00e0ff;
            margin-bottom: 20px;
            letter-spacing: 2px;
        }

        .hero p {
            max-width: 600px;
            margin-bottom: 30px;
        }

        .buttons {
            display: flex;
            gap: 20px;
        }

        .btn-primary {
            background: linear-gradient(90deg, #00c6ff, #0072ff);
            padding: 12px 30px;
            border-radius: 30px;
            text-decoration: none;
            color: white;
        }

        .btn-outline {
            border: 2px solid white;
            padding: 12px 30px;
            border-radius: 30px;
            text-decoration: none;
            color: white;
        }
    </style>
</head>
<body>

<div class="container">

    <div class="hero">
        <h1>SMK NEGERI 4</h1>
        <h2>BOJONEGORO</h2>
        <p>
            Website Pengaduan Sarana & Prasarana Sekolah
            yang cepat, mudah, dan transparan.
        </p>

        <div class="buttons">
            <a href="{{ route('login') }}" class="btn-primary">Login</a>
            <a href="{{ route('register') }}" class="btn-outline">Daftar Sekarang</a>
        </div>
    </div>

</div>

</body>
</html>