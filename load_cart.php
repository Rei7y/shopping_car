<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <title>購物車</title>
    <style>
        body {
            background-color: #f0f0f0;
            font-family: Arial, sans-serif;
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            background-color: #ffffff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            overflow: hidden;
        }
        th, td {
            padding: 12px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #81D8D0;
            color: white;
        }
        .price, .quantity, .item-total {
            font-weight: bold;
        }
        .quantity input {
            width: 50px;
            text-align: center;
        }
        button {
            background-color: #81D8D0;
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        button:hover {
            background-color: #66bfbf;
        }
        button:disabled {
            background-color: #ccc;
            cursor: not-allowed;
        }
        .delete {
            background-color: #ff6b6b;
        }
        .delete:hover {
            background-color: #e55050;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
<?php
include 'conndb.php';

$sql = "SELECT car.p_no, car.quantity, products.name, products.price 
        FROM car 
        JOIN products ON car.p_no = products.no";
$result = $conn->query($sql);

$total = 0;
$output = '';

while($row = $result->fetch_assoc()) {
    $itemTotal = $row['price'] * $row['quantity'];
    $total += $itemTotal;
    
    $output .= '<tr>
        <td><input type="checkbox" class="item-select"></td>
        <td>' . $row['name'] . '</td>
        <td class="price">' . $row['price'] . ' 元</td>
        <td>
            <button class="decrease" data-pno="' . $row['p_no'] . '">-</button>
            <input type="number" class="quantity" data-pno="' . $row['p_no'] . '" value="' . $row['quantity'] . '" min="1">
            <button class="increase" data-pno="' . $row['p_no'] . '">+</button>
        </td>
        <td class="item-total">' . $itemTotal . ' 元</td>
        <td><button class="delete" data-pno="' . $row['p_no'] . '">刪除</button></td>
    </tr>';
}
?>
    <h1>我的購物車</h1>
    <table id="cart">
        <thead>
            <tr>
                <th><input type="checkbox" id="selectAll"> 全選</th>
                <th>商品名稱</th>
                <th>單價</th>
                <th>數量</th>
                <th>總價</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            <?php echo $output; ?>
        </tbody>
    </table>
    <h3>總金額：<span id="totalPrice"><?php echo $total; ?></span> 元</h3>
    <button id="checkout">結帳選擇的商品</button>

    <script>
        $(document).ready(function() {
            function updateTotalPrice() {
                var total = 0;
                $('#cart tbody tr').each(function() {
                    if ($(this).find('.item-select').is(':checked')) {
                        var price = parseFloat($(this).find('.price').text());
                        var quantity = parseInt($(this).find('.quantity').val());
                        total += price * quantity;
                    }
                });
                $('#totalPrice').text(total);
            }

            $(document).on('click', '.increase', function() {
                var p_no = $(this).data('pno');
                updateCart('increase', p_no, 1);
            });

            $(document).on('click', '.decrease', function() {
                var p_no = $(this).data('pno');
                updateCart('decrease', p_no, 1);
            });

            $(document).on('input', '.quantity', function() {
                var p_no = $(this).data('pno');
                var newQuantity = parseInt($(this).val());
                if (newQuantity <= 0) {
                    updateCart('delete', p_no, 0);
                } else {
                    updateCart('update', p_no, newQuantity);
                }
            });

            $(document).on('click', '.delete', function() {
                var p_no = $(this).data('pno');
                updateCart('delete', p_no, 0);
            });

            $('#selectAll').on('change', function() {
                $('.item-select').prop('checked', this.checked);
                updateTotalPrice();
            });

            $('#cart').on('change', '.item-select', function() {
                updateTotalPrice();
            });

            $('#checkout').on('click', function() {
                var selectedTotal = 0;
                var selectedItems = [];

                $('.item-select:checked').each(function() {
                    var row = $(this).closest('tr');
                    var p_no = row.find('.delete').data('pno');
                    var price = parseFloat(row.find('.price').text());
                    var quantity = parseInt(row.find('.quantity').val());

                    selectedTotal += price * quantity;
                    selectedItems.push({ p_no: p_no, quantity: quantity });
                });

                if (selectedTotal > 0) {
                    $.ajax({
                        url: 'checkout.php',
                        method: 'POST',
                        data: { items: selectedItems },
                        success: function(response) {
                            alert('結帳成功！總金額：' + selectedTotal + ' 元');
                            location.reload();
                        }
                    });
                } else {
                    alert('請選擇至少一件商品進行結帳');
                }
            });

            function updateCart(action, p_no, quantity) {
                $.ajax({
                    url: 'update_cart.php',
                    method: 'POST',
                    data: { action: action, p_no: p_no, quantity: quantity },
                    success: function(response) {
                        location.reload();
                    }
                });
            }

            updateTotalPrice();
        });
    </script>
</body>
</html>
