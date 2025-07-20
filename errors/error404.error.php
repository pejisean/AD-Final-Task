<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>404 Not Found</title>
    <style>
        body {
            background: #181e22;
            color: #fff;
            font-family: 'Montserrat', sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }

        .error-container {
            text-align: center;
        }

        .error-code {
            font-size: 5rem;
            color: #DA6015;
            margin-bottom: 0.5rem;
        }

        .error-message {
            font-size: 1.5rem;
            margin-bottom: 1.5rem;
        }

        a {
            color: #fc7013;
            text-decoration: none;
            font-weight: bold;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="error-container">
        <div class="error-code">404</div>
        <div class="error-message">Page Not Found</div>
        <a href="/index.php">Go back to Home</a>