
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
       
        body{
            width: 100vw;
            height: 80vh;
            display: flex;
            justify-content: center;
            align-items: center;
          
        }
    </style>

</head>

<body>

<?php
// processa_cadastro.php
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT); // Criptografar a senha

    // Verificar se o email já está cadastrado
    $stmt = $conn->prepare("SELECT id FROM usuarios WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows > 0) {
        echo '<div class="container mt-4">
                <h2>Email já cadastrado.</h2>
                <p> <a href="cadastrar.php" class="btn btn-primary">Tente novamente</a></p>
              </div>';
        exit;
    }

    // Inserir novo usuário
    $stmt = $conn->prepare("INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $nome, $email, $senha);
    
    if ($stmt->execute()) {
        // Mensagem de sucesso com botão para redirecionar para login.php
        echo '<div class="container mt-4">
                <h2>Cadastro realizado com sucesso!</h2>
                <p>Agora você pode <a href="login.php" class="btn btn-primary">Fazer login</a></p>
              </div>';
    } else {
        // Mensagem de erro
        echo '<div class="container mt-4">
                <h2>Teste Falhou</h2>
                <p>Esse teste não foi executado.</p>
              </div>';
    }
    
    
    
    $stmt->close();
    $conn->close();
}
?>

</body>
</html>
