<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <title>商品列表</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
        }
        
        h1 {
            color: #4db6ac;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        table th, table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        table th {
            background-color: #66bfbf;
            color: white;
        }

        table tr:hover {
            background-color: #e0f7fa;
        }

        input[type="number"] {
            padding: 5px;
            width: 60px;
            border: 1px solid #ccc;
            border-radius: 5px;
            outline: none;
        }

        button {
            padding: 8px 15px;
            background-color: #4db6ac;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #388e8e;
        }
    </style>
</head>
<body>
<?php require_once 'nav.php'; ?>
    <h1>商品列表</h1>

    <table>
        <thead>
            <tr>
                <th>商品名稱</th>
                <th>價格</th>
                <th>數量</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            <?php
            include 'conndb.php';

            $sql = "SELECT no, name, price FROM products";
            $result = $conn->query($sql);

            while($row = $result->fetch_assoc()) {
                echo '<tr>
                    <td>' . $row['name'] . '</td>
                    <td>' . $row['price'] . ' 元</td>
                    <td><input type="number" id="quantity_' . $row['no'] . '" value="1" min="1"></td>
                    <td><button class="add-to-cart" data-pno="' . $row['no'] . '">新增至購物車</button></td>
                </tr>';
            }

            $conn->close();
            ?>
        </tbody>
    </table>

    <script>
        $(document).on('click', '.add-to-cart', function() {
            var p_no = $(this).data('pno');
            var quantity = $('#quantity_' + p_no).val();

            $.ajax({
                url: 'add_to_cart.php',
                method: 'POST',
                data: { p_no: p_no, quantity: quantity },
                success: function(response) {
                    if(response === 'Success') {
                        alert('商品已新增至購物車');
                    } else {
                        alert('新增至購物車時發生錯誤：' + response);
                    }
                }
            });
        });
    </script>
</body>
</html>
