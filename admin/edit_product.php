<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Produto</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            height: 100vh;
            width: 100vw;
            display: flex;
            justify-content: center;
            align-items: center;
        }

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

        input,
        textarea {
            background-color: rgb(41, 41, 41) !important;
            border: none !important;
            color: white !important;
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

        #foto {
            background-color: rgb(41, 41, 41) !important;
            height: 80px;
            display: flex;
            align-items: center;

            #file-upload-button {
                background-color: red !important;
            }
        }

        .back {
            color: #007bff;
            position: fixed;
            top: 10px;
            left: 20px;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 20px;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <a href="list_products.php" class="back">< Voltar</a>
    <div class="container mt-4">
        <h2>Editar Produto</h2>
        <?php
        include 'db_connect.php';

        $produto_id = $_GET['id'];
        $stmt = $conn->prepare("SELECT * FROM produtos WHERE id = ?");
        $stmt->bind_param("i", $produto_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $produto = $result->fetch_assoc();
        ?>
        <form action="processa_edit_product.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $produto['id']; ?>">
            <div class="form-group">
                <label for="nome">Nome</label>
                <input type="text" class="form-control" id="nome" name="nome" value="<?php echo $produto['nome']; ?>"
                    required>
            </div>
            <div class="form-group">
                <label for="descricao">Descrição</label>
                <textarea class="form-control" id="descricao" name="descricao" rows="3"
                    required><?php echo $produto['descricao']; ?></textarea>
            </div>
            <div class="form-group">
                <label for="preco">Preço</label>
                <input type="number" step="0.01" class="form-control" id="preco" name="preco"
                    value="<?php echo $produto['preco']; ?>" required>
            </div>
            <div class="form-group">
                <label for="foto">Foto (deixe em branco para manter a foto atual)</label>
                <input type="file" class="form-control" id="foto" name="foto">
            </div>
            <button type="submit" class="btn btn-primary">Salvar Alterações</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>