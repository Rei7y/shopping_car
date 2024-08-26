<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>新增新產品</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0; /* 淺灰色背景 */
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        h1 {
            color: #333;
            text-align: center;
        }

        form {
            background-color: #81d8d0; /* 蒂芬妮綠 */
            padding: 20px;
            border-radius: 4px; /* 調整圓角幅度 */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
        }

        label {
            font-size: 1.1em;
            margin-bottom: 5px;
            display: block;
            color: #333;
        }

        input[type="text"], input[type="number"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 1em;
        }

        input[type="submit"] {
            width: 100%;
            background-color: #007bff; /* 藍色按鈕 */
            color: white;
            padding: 10px;
            border: none;
            border-radius: 4px;
            font-size: 1em;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        #responseMessage {
            margin-top: 20px;
            font-size: 1.1em;
            color: #28a745;
            text-align: center;
        }
    </style>
</head>
<body>
<?php require_once 'nav.php'; ?>
    <h1>新增新產品</h1>
    <form id="productForm">
        <label for="name">產品名稱:</label>
        <input type="text" id="name" name="name" required>
        
        <label for="price">產品價格:</label>
        <input type="number" id="price" name="price" required>
        
        <input type="submit" value="送出">
    </form>

    <div id="responseMessage"></div>

    <script>
        $(document).ready(function(){
            $("#productForm").on("submit", function(event){
                event.preventDefault(); // Prevent the default form submission

                $.ajax({
                    url: "insert_product.php", // PHP script to process the form data
                    method: "POST",
                    data: $(this).serialize(), // Serialize form data
                    success: function(response){
                        $("#responseMessage").html(response); // Display success or error message
                        $("#productForm")[0].reset(); // Reset the form
                    }
                });
            });
        });
    </script>
</body>
</html>
