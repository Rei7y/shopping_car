<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$database = "shopping_car";

$message = "";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_errno) {
    $message = "MySQL 連接失敗: " . $conn->connect_error;
} else {
    $message = "MySQL 連接成功！";
}

$conn->set_charset('utf8mb4');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>數據庫連接結果</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0; 
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .result-box {
            background-color: #81d8d0; 
            padding: 20px;
            border-radius: 4px; 
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
            text-align: center;
        }

        .result-box h1 {
            color: #333;
        }

        .result-box p {
            color: white;
            font-size: 1.2em;
        }
    </style>
</head>
<body>
    <div class="result-box">
        <h1>連接結果</h1>
        <p><?php echo $message; ?></p>
    </div>
</body>
</html>
