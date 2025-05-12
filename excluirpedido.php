<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    $id = intval($_POST['id']);
    
    
    $check_sql = "SELECT id FROM pedidos WHERE id = $id";
    $check_result = $conexao->query($check_sql);
    
    if ($check_result->num_rows > 0) {
        
        $sql = "DELETE FROM pedidos WHERE id = $id";
        
    if ($conexao->query($sql)) {
            header("Location: listarpedido.php?msg=Pedido+excluído+com+sucesso");
            exit();
        } else {
            header("Location: listarpedido.php?erro=Erro+ao+excluir+pedido");
            exit();
        }
    } else {
        header("Location: listarpedido.php?erro=Pedido+não+encontrado");
        exit();
    }
} else {
    header("Location: listarpedido.php");
    exit();
}
