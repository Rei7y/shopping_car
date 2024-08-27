<?php
include 'conndb.php';

$response = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $items = $_POST['items'];

    foreach ($items as $item) {
        $p_no = $item['p_no'];
        $sql = "DELETE FROM car WHERE p_no = $p_no";
        
        if ($conn->query($sql) === TRUE) {
            $response .= "商品編號 $p_no 已成功刪除。<br>";
        } else {
            $response .= "商品編號 $p_no 刪除失敗: " . $conn->error . "<br>";
        }
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>刪除操作結果</title>
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
            word-wrap: break-word; 
        }
    </style>
</head>
<body>
    <div class="result-box">
        <h1>操作結果</h1>
        <p><?php echo $response ? $response : "沒有進行任何操作。"; ?></p>
    </div>
</body>
</html>
