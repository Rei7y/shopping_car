<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>產品處理結果</title>
    <style>
        body {
            background-color: #f0f0f0;
            font-family: Arial, sans-serif;
            color: #333;
            text-align: center;
            padding: 50px;
        }
        .message {
            background-color: #81D8D0;
            color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            margin: 20px auto;
            font-size: 18px;
        }
    </style>
</head>
<body>

<?php
include 'conndb.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $create_at = date("Y-m-d H:i:s");
    $update_at = $create_at;

    $check_stmt = $conn->prepare("SELECT * FROM products WHERE name = ?");
    $check_stmt->bind_param("s", $name);
    $check_stmt->execute();
    $result = $check_stmt->get_result();

    if ($result->num_rows > 0) {
        $update_stmt = $conn->prepare("UPDATE products SET price = ?, update_at = ? WHERE name = ?");
        $update_stmt->bind_param("dss", $price, $update_at, $name);

        if ($update_stmt->execute()) {
            echo "<div class='message'>產品已成功更新！</div>";
        } else {
            echo "<div class='message'>更新產品時出錯：" . $update_stmt->error . "</div>";
        }

        $update_stmt->close();
    } else {
        $insert_stmt = $conn->prepare("INSERT INTO products (name, price, create_at, update_at) VALUES (?, ?, ?, ?)");
        $insert_stmt->bind_param("sdss", $name, $price, $create_at, $update_at);

        if ($insert_stmt->execute()) {
            echo "<div class='message'>產品已成功新增！</div>";
        } else {
            echo "<div class='message'>新增產品時出錯：" . $insert_stmt->error . "</div>";
        }

        $insert_stmt->close();
    }

    $check_stmt->close();
    $conn->close();
}
?>

</body>
</html>
