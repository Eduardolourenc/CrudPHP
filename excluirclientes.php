<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    $id = intval($_POST['id']);
    
    
    $check_sql = "SELECT id FROM usuarios WHERE id = $id";
    $check_result = $conexao->query($check_sql);
    
    if ($check_result->num_rows > 0) {
        
        $sql = "DELETE FROM usuarios WHERE id = $id";
        
    if ($conexao->query($sql)) {
            header("Location: listarclientes.php?msg=cliente+excluído+com+sucesso");
            exit();
        } else {
            header("Location: listarclientes.php?erro=Erro+ao+excluir+cliente");
            exit();
        }
    } else {
        header("Location: listarclientes.php?erro=cliente+não+encontrado");
        exit();
    }
} else {
    header("Location: listarclientes.php");
    exit();
}
