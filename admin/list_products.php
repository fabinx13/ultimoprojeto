<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
    header("Location: login.php");
    exit;
}

include 'db_connect.php'; // Conexão com o banco de dados

// Consultar os produtos
$result = $conn->query("SELECT * FROM produtos");

// Verificar status da mensagem
$status = isset($_GET['status']) ? $_GET['status'] : '';
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listar Produtos</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .navbar {
            background-color: rgb(67, 67, 67) !important;
            position: fixed;
            top: 0;
            width: 100vw;
            padding: .8em;
            z-index: 9999;
            border-bottom: 1px solid #b5b5b5;
        }

        .nav-link,
        .navbar-brand {
            color: white !important;
        }

        .circle {
            border-radius: 50%;
            border-radius: 50%;
            background-color: #007bff;
            color: white;
            padding: 0px 12px;
            text-align: center;
            line-height: 40px;
            font-size: 18px;
            font-weight: bold;
            margin-right: 10px;
        }

        .navbar-text {
            color: white !important;
            font-size: 18px;
        }

        .account {
            .navbar-text {
                padding: 0;
                text-transform: capitalize;
            }

            .nav-link {
                padding: 0;
                color: red !important;
                text-transform: uppercase;
            }
        }

        .card {
            background-color: rgb(67, 67, 67) !important;
            color: white;
            box-shadow: 0 4px 8px #007bff;
            min-height: 400px;

            img {
                height: 200px;
            }
        }

        .card-body {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            border-radius: 5px;
            padding: 15px !important;

            .btn-warning {
                background-color: #007bff;
                border: 2px solid #007bff;
            }

            .btn-danger {
                background-color: transparent;
                color: red;
                border: 1px solid red;
            }
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Admin</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ml-auto">
                <!-- Botão para consultar pedidos -->
                <li class="nav-item">
                    <a href="consultar_pedidos.php" class="btn btn-info mr-2">Consultar Pedidos</a>
                </li>
                <!-- Botão para sair -->
                <li class="nav-item">
                    <a href="logout.php" class="btn btn-danger">Sair</a>
                </li>
            </ul>
        </div>
    </nav>
    <div style="height: 90px"></div>

    <div class="container mt-4">
        <h2>Listar Produtos</h2>
        <a href="create_product.php" class="btn btn-primary mb-3">Criar Novo Produto</a>
        <div class="row">
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <img src="uploads/<?php echo $row['foto']; ?>" class="card-img-top"
                                alt="<?php echo $row['nome']; ?>">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $row['nome']; ?></h5>
                                <p class="card-text">R$ <?php echo number_format($row['preco'], 2, ',', '.'); ?></p>
                                <div class="d-flex flex-column">
                                    <a href="edit_product.php?id=<?php echo $row['id']; ?>" class="btn btn-warning">Editar</a>
                                    <!-- Botão para abrir o modal de confirmação -->
                                    <button class="btn btn-danger mt-2" data-toggle="modal"
                                        data-target="#deleteModal<?php echo $row['id']; ?>">Excluir</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal de confirmação para excluir produto -->
                    <div class="modal fade" style="z-index: 999999" id="deleteModal<?php echo $row['id']; ?>" tabindex="-1" role="dialog"
                        aria-labelledby="deleteModalLabel<?php echo $row['id']; ?>" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="deleteModalLabel<?php echo $row['id']; ?>">Confirmar Exclusão
                                    </h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    Tem certeza que deseja excluir o produto "<?php echo $row['nome']; ?>"?
                                </div>
                                <div class="modal-footer">
                                    <!-- Formulário de exclusão -->
                                    <form action="delete_product.php" method="post">
                                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                        <button type="submit" class="btn btn-danger">Excluir</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                <?php endwhile; ?>
            <?php else: ?>
                <p>Nenhum produto encontrado.</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Modal de sucesso -->
    <?php if ($status === 'success'): ?>
        <div class="modal fade" style="z-index: 99999" id="successModal" tabindex="-1" role="dialog" aria-labelledby="successModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-success text-white">
                        <h5 class="modal-title" id="successModalLabel">Sucesso</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-check-circle fa-3x text-success mr-3"></i>
                            <div>
                                Produto excluído com sucesso!
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- Mostrar o modal de sucesso se o status for success -->
    <?php if ($status === 'success'): ?>
        <script>
            $(document).ready(function () {
                $('#successModal').modal('show');
            });
        </script>
    <?php endif; ?>
</body>

</html>

<?php
$conn->close();
?>