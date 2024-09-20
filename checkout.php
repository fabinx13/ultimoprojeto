 
 <?php
 
session_start();
include 'admin/db_connect.php';

// Verificar se o carrinho está vazio
if (empty($_SESSION['cart'])) {
    header('Location: cart.php');
    exit();
}

// Verificar se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit();
}

// Processar o formulário de checkout
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obter dados do formulário
    $valor = 50.00; // Valor em reais (por exemplo, R$10,00)

    // Configurações para o PayPal
    $paypal_url = 'https://sandbox.paypal.com'; // URL para o ambiente de produção
    $paypal_email = 'sb-iyvaf32714831@business.example.com'; // Substitua pelo e-mail do PayPal

    // Criar um ID de pedido fictício
    $pedido_id = rand(1000, 9999);
    $_SESSION['pedido_id'] = $pedido_id;

    // Redirecionar para o PayPal
    $paypal_args = array(
        'cmd' => '_xclick',
        'business' => $paypal_email,
        'item_name' => 'Compra na loja virtual',
        'amount' => number_format($valor, 2, '.', ''),
        'currency_code' => 'BRL',
        'return' => 'http://olpermotors.shop/confirmacao_pagamento.php',
        'cancel_return' => 'http://olpermotors.shop/confirmacao_pagamento.php', // Opcional
        'notify_url' => 'http://olpermotors.shop/confirmacao_pagamento.php' // Opcional
    );

    $query_string = http_build_query($paypal_args);
    header('Location: ' . $paypal_url . '?' . $query_string);
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Finalizar Compra</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body{
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            width: 100vw;
        }

        .container {
            background-color: rgb(67, 67, 67) !important;
            color: white;
            box-shadow: 0 4px 8px #007bff;
            padding: 1em;
            border-radius: 15px;
            width: 500px;

            input {
                background-color: rgb(41, 41, 41) !important;
                border: none;
                width: 220px;
                color: white !important;
            }
        }

        button {
            width: 100%;
            margin-top: 20px;
            border: none !important;
            background-color: #007bff !important;
        }

        .back {
            color: #007bff;
            position: fixed;
            top: 90px;
            left: 20px;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 20px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <?php include 'header.php'; ?>
    <a href="cart.php" class="back">
        < Voltar
    </a>
    <div class="container mt-4">
        <h2>Finalizar Compra</h2>
        <form action="checkout.php" method="post">
            <button type="submit" class="btn btn-success">Finalizar Compra</button>
        </form>
    </div>
</body>
</html>