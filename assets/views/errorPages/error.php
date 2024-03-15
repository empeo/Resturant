<?php
if(!isset($_SESSION["usernameRemeberMe"]) and !isset($_SESSION["username"])){
    echo "<script>alert('login first!')</script>";
    header("location: ../../../index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../../images/favicon/resturant_favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="../../style/bootstrap.min.css">
    <link rel="stylesheet" href="../../style/style.css">
    <title>403 Forbidden</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            font-weight: bolder;
        }

        .error-container {
            text-align: center;
        }

        .error-code {
            font-size: 120px;
            color: #e74c3c;
        }

        .error-message {
            font-size: 24px;
            color: #333;
            margin-bottom: 20px;
        }

        .back-link {
            text-decoration: none;
            color: #3498db;
            font-weight: bold;
            font-size: 18px;
            border: 2px solid #3498db;
            padding: 10px 20px;
            border-radius: 5px;
            transition: background-color 0.3s, color 0.3s;
        }

        .back-link:hover {
            background-color: #3498db;
            color: #fff;
        }
    </style>
</head>
<body>
    <div class="error-container">
        <div class="error-code">403</div>
        <div class="error-message">Forbidden - Access Denied</div>
        <p>Sorry, but you don't have permission to access this page.</p>
        <div class="container__back"><a href="../home.php" class="back-link">Go Back</a></div>
    </div>
    <script src="../../dynamic/bootstrap.bundle.min.js"></script>

</body>
</html>
