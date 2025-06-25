<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Hasher</title>
    <style>
        body {
            background: #222;
            color: #fff;
            font-family: Arial, sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            background: #333;
            padding: 32px 24px;
            border-radius: 10px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.2);
        }

        input[type="password"] {
            padding: 8px;
            border-radius: 4px;
            border: none;
            margin-right: 8px;
            font-size: 1rem;
        }

        button {
            padding: 8px 16px;
            border-radius: 4px;
            border: none;
            background: #ffb347;
            color: #222;
            font-weight: bold;
            cursor: pointer;
        }

        .hash {
            margin-top: 20px;
            word-break: break-all;
            background: #222;
            padding: 12px;
            border-radius: 6px;
            font-size: 1rem;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Password Hasher</h2>
        <form method="post">
            <input type="password" name="password" placeholder="Enter password" required>
            <button type="submit">Hash</button>
        </form>
        <?php if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['password'])): ?>
            <div class="hash">
                <strong>Hashed Password:</strong><br>
                <?php echo htmlspecialchars(password_hash($_POST['password'], PASSWORD_DEFAULT)); ?>
            </div>
        <?php endif; ?>
    </div>
</body>

</html>