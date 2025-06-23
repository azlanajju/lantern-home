<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lantern Home - Coming Soon</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            background: #181818;
            color: #fff;
            font-family: 'Roboto', sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }

        .logo {
            width: 120px;
            margin-bottom: 32px;
        }

        .coming-soon {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 16px;
            letter-spacing: 2px;
        }

        .quote {
            font-size: 1.2rem;
            color: #ffb347;
            margin-bottom: 40px;
            font-style: italic;
        }

        .footer {
            position: absolute;
            bottom: 24px;
            font-size: 0.95rem;
            color: #888;
        }
    </style>
</head>

<body>
    <img src="../assets/logos/lantern-home.png" alt="Lantern Home Logo" class="logo">
    <div class="coming-soon">Coming Soon</div>
    <div class="quote">“Patience is a virtue. Luckily, sarcasm is free.”</div>
    <div class="footer">&copy; <?php echo date('Y'); ?> Lantern Home. All rights reserved.</div>
</body>

</html>