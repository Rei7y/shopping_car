<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <title>購物車</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 20px;
        }

        h1 {
            color: #333;
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 15px;
            text-align: center;
            border: 1px solid #ddd;
        }

        th {
            background-color: #81d8d0;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        input[type="checkbox"] {
            transform: scale(1.2);
        }

        button, .increase, .decrease, .delete {
            background-color: #81d8d0;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover, .increase:hover, .decrease:hover, .delete:hover {
            background-color: #68b9b0;
        }

        .quantity {
            width: 50px;
            text-align: center;
        }

        #checkout {
            margin-top: 20px;
            width: 100%;
            font-size: 1.2em;
        }

        #totalPrice {
            font-weight: bold;
            color: #81d8d0;
        }
    </style>
</head>
<body>
    <?php require_once 'nav.php'; ?>
    
    <h1>我的購物車</h1>

    <table id="cart" border="1">
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
        </tbody>
    </table>

    <h3>總金額：<span id="totalPrice">0</span> 元</h3>
    <button id="checkout">結帳選擇的商品</button>

    <script>
        function loadCart() {
            $.ajax({
                url: 'load_cart.php',
                method: 'GET',
                success: function(response) {
                    $('#cart tbody').html(response);
                    updateTotalPrice();
                }
            });
        }

        function updateCart(action, p_no, quantity) {
            $.ajax({
                url: 'update_cart.php',
                method: 'POST',
                data: { action: action, p_no: p_no, quantity: quantity },
                success: function(response) {
                    loadCart();
                }
            });
        }

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
                selected
