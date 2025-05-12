<?php

include 'config.php'; 

if ($conexao->connect_error) {
    die("Falha na conexão: " . $conexao->connect_error);
}


if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    $sql = "SELECT id, nome, telefone FROM usuarios WHERE id = $id";
    $result = $conexao->query($sql);

    if ($result->num_rows > 0) {
        $pedido = $result->fetch_assoc();
    } else {
        echo "Pedido não encontrado.";
        exit;
    }
} else {
    echo "ID não fornecido.";
    exit;
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $telefone = $_POST['telefone'];
    

    $sql = "UPDATE usuarios SET 
                nome = '$nome', 
                telefone = '$telefone'
            WHERE id = $id";

    if ($conexao->query($sql) === TRUE) {
        echo "Cliente atualizado com sucesso!";
        
        header("Location: listarclientes.php");
        exit;
    } else {
        echo "Erro ao atualizar: " . $conexao->error;
    }
}
?>


