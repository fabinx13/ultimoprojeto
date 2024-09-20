<?php
session_start();
include 'admin/db_connect.php';

// Contagem de itens do carrinho
$cart_count = isset($_SESSION['cart']) ? array_sum(array_column($_SESSION['cart'], 'quantidade')) : 0;

// Filtro de busca
$search = isset($_GET['search']) ? $_GET['search'] : '';

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loja Virtual</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            background-color: white !important;
        }

        .card {
            background-color: rgb(67, 67, 67) !important;
            color: white;
            box-shadow: 0 4px 8px #007bff;

        }

        .card-body {
            border-radius: 5px;
            padding: 15px !important;
            
        }

        .cccc {
            position: relative;
            top: -30px;

            input {
                border-width: 2px;
                width: 100%;
                border-right: none;
            }

            .btn-primary {
                padding: 0;
                height: 38px;
                width: 38px;
                border-radius: 0;
                border-top-right-radius: 5px;
                border-bottom-right-radius: 5px;

                svg {
                    fill: white !important;
                    padding: 0;
                    width: 20px;
                    height: 20px;
                }
            }
        }
        .imagem{
            width: 150px;
            /* Para garantir que a imagem preencha o container */
            transform: scaleX(1.6);
            /* Estica a imagem na horizontal */
            transform-origin: left;
            /* Define o ponto de origem para o lado esquerdo */
        }
    </style>
</head>

<body>
    <?php include 'header.php'; ?>

    <form method="GET" action="" class="d-flex w-100 justify-content-center align-items-center mb-3 cccc">
        <div class="form-group d-flex align-items-center m-0" style="width: 300px;">
            <input type="text" name="search" class="form-control" placeholder="Buscar produto..."
                value="<?php echo htmlspecialchars($search); ?>">
        </div>
        <button type="submit" class="btn btn-primary">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                <title>magnify</title>
                <path
                    d="M9.5,3A6.5,6.5 0 0,1 16,9.5C16,11.11 15.41,12.59 14.44,13.73L14.71,14H15.5L20.5,19L19,20.5L14,15.5V14.71L13.73,14.44C12.59,15.41 11.11,16 9.5,16A6.5,6.5 0 0,1 3,9.5A6.5,6.5 0 0,1 9.5,3M9.5,5C7,5 5,7 5,9.5C5,12 7,14 9.5,14C12,14 14,12 14,9.5C14,7 12,5 9.5,5Z" />
            </svg>
        </button>
    </form>

    <div class="container mt-4">
        <!-- Campo de busca -->
        <div class="row mt-4">
            <!-- Exemplo de card de produto -->
            <?php
            include 'admin/db_connect.php';

            // Consulta para filtrar produtos pelo nome
            $query = "SELECT * FROM produtos WHERE nome LIKE '%$search%'";
            $result = $conn->query($query);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $nome = htmlspecialchars($row['nome']);
                    $descricao = htmlspecialchars($row['descricao']);
                    $preco = number_format($row['preco'], 2, ',', '.');
                    $foto = htmlspecialchars($row['foto']);
                    $id = $row['id'];
                    ?>
                    <div class="col-md-4 mb-4">
                        <div class="card" style="width: 15rem;">
                            <img src="admin/uploads/<?php echo $foto; ?>" class="card-img-top imagem" alt="<?php echo $nome; ?>">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $nome; ?></h5>
                                <p class="card-text">R$ <?php echo $preco; ?></p>
                                <div class="d-flex flex-column">
                                    <a href="produto.php?id=<?php echo $id; ?>" class="btn btn-primary mb-2">Ver Detalhes</a>
                                    <a href="adicionar_carrinho.php?id=<?php echo $id; ?>" class="btn btn-success">Comprar</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            } else {
                echo "Nenhum produto encontrado.";
            }

            $conn->close();
            ?>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>