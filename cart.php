<?php
session_start();
include 'admin/db_connect.php';

// Contagem de itens do carrinho
$cart_count = isset($_SESSION['cart']) ? array_sum(array_column($_SESSION['cart'], 'quantidade')) : 0;

// Verificar se o carrinho está vazio
$is_cart_empty = empty($_SESSION['cart']);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrinho de Compras</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    <style>
        .container {
            background-color: rgb(67, 67, 67) !important;
            color: white;
            box-shadow: 0 4px 8px #007bff;
            padding: 50px;
        }

        th,
        tr {
            color: white;
        }

        .btn-sm {
            color: red;
            background-color: transparent;

            &:hover {
                background-color: transparent;
                color: red;
            }
        }

        .no-product {
            font-size: 28px;
            height: 250px;
            width: 100%;
            display: flex;
            justify-content: center;
            text-align: center;
            align-items: center;
        }

        .btn-success {
            background-color: #007bff !important;
            border: hidden;
            padding: .8em 2em;
        }
    </style>
</head>

<body>

    <?php include 'header.php'; ?>

    <div class="container mt-4">
        <h2>Carrinho de Compras</h2>

        <?php if ($is_cart_empty): ?>
            <p>Seu carrinho está vazio.</p>
        <?php else: ?>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Produto</th>
                        <th>Preço</th>
                        <th>Quantidade</th>
                        <th>Total</th>
                        <th>Ação</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $total = 0;
                    foreach ($_SESSION['cart'] as $id => $item):
                        $item_total = $item['preco'] * $item['quantidade'];
                        $total += $item_total;
                        ?>
                        <tr>
                            <td><?php echo htmlspecialchars($item['nome']); ?></td>
                            <td>R$ <?php echo number_format($item['preco'], 2, ',', '.'); ?></td>
                            <td><?php echo htmlspecialchars($item['quantidade']); ?></td>
                            <td>R$ <?php echo number_format($item_total, 2, ',', '.'); ?></td>
                            <td>
                                <a href="remover_carrinho.php?id=<?php echo $id; ?>" class="btn btn-danger btn-sm">Excluir</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <tr>
                        <td colspan="3"><strong>Total</strong></td>
                        <td><strong>R$ <?php echo number_format($total, 2, ',', '.'); ?></strong></td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
            <div class="d-flex justify-content-end">
                <a href="checkout.php" class="btn btn-success">Finalizar Compra</a>
            </div>
        <?php endif; ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>