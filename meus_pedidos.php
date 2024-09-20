<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php'); // Redirecionar para login se não estiver logado
    exit();
}

$user_id = $_SESSION['usuario_id'];
$sql = "SELECT * FROM pedidos WHERE usuario_id = ? ORDER BY data_pedido DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meus Pedidos</title>
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
        <h2>Meus Pedidos</h2>
        <?php if ($result->num_rows > 0): ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>ID do Pedido</th>
                        <th>Data do Pedido</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($pedido = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($pedido['id']); ?></td>
                            <td><?php echo htmlspecialchars($pedido['data_pedido']); ?></td>
                            <td>R$ <?php echo number_format($pedido['total'], 2, ',', '.'); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="no-product">
                <p>Você ainda não fez nenhum pedido.</p>
            </div>
        <?php endif; ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>