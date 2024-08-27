<?php
include 'conndb.php';

$p_no = $_POST['p_no'];
$quantity = $_POST['quantity'];
$create_at = date("Y-m-d H:i:s");
$update_at = $create_at;

// 檢查該商品是否已在購物車中
$sql = "SELECT * FROM car WHERE p_no = $p_no";
$result = $conn->query($sql);

// 初始化訊息變數
$message = "";

if ($result->num_rows > 0) {
    // 如果已存在，則更新數量
    $sql = "UPDATE car SET quantity = quantity + $quantity, updata_at = '$update_at' WHERE p_no = $p_no";
    $message = "商品數量已更新。";
} else {
    // 如果不存在，則新增一筆新的紀錄
    $sql = "INSERT INTO car (p_no, quantity, create_at, updata_at) VALUES ($p_no, $quantity, '$create_at', '$update_at')";
    $message = "商品已加入購物車。";
}

if ($conn->query($sql) === TRUE) {
    $response = "Success: " . $message;
} else {
    $response = "Error: " . $conn->error;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>購物車操作結果</title>
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
        <h1>操作結果</h1>
        <p><?php echo $response; ?></p>
    </div>
</body>
</html>
