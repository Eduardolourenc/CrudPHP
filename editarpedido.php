<?php
include("config.php");


if(!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: listarpedido.php");
    exit();
}

$id_pedido = intval($_GET['id']);


$sql_pedido = "SELECT p.*, u.nome as cliente_nome 
               FROM pedidos p
               JOIN usuarios u ON p.usuario_id = u.id
               WHERE p.id = $id_pedido";
$result_pedido = mysqli_query($conexao, $sql_pedido);

if(mysqli_num_rows($result_pedido) == 0) {
    header("Location: listarpedido.php");
    exit();
}

$pedido = mysqli_fetch_assoc($result_pedido);


$sql_usuarios = "SELECT id, nome FROM usuarios";
$result_usuarios = mysqli_query($conexao, $sql_usuarios);


if($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario_id = mysqli_real_escape_string($conexao, $_POST['usuario_id']);
    $pedido_texto = mysqli_real_escape_string($conexao, $_POST['pedido']);
    $data_pedido = mysqli_real_escape_string($conexao, $_POST['data_pedido']);
    $endereco = mysqli_real_escape_string($conexao, $_POST['endereco']);

    $sql_update = "UPDATE pedidos SET
                  usuario_id = '$usuario_id',
                  pedido = '$pedido_texto',
                  data_pedido = '$data_pedido',
                  endereco = '$endereco'
                  WHERE id = $id_pedido";

    if(mysqli_query($conexao, $sql_update)) {
        header("Location: listarpedido.php?sucesso=1");
        exit();
    } else {
        $erro = "Erro ao atualizar pedido: " . mysqli_error($conexao);
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Pedido - Sistema Lanchonete</title>
    <link rel="stylesheet" href="css/editarpedido.css">
    
</head>
<body>
    <div class="container">
        <form action="editarpedido.php?id=<?= $id_pedido ?>" method="POST">
            <fieldset class="header">
                <legend class="legenda"><b>Editar Pedido #<?= $id_pedido ?></b></legend>
            </fieldset>
            
            <?php if(isset($erro)): ?>
                <div class="error-message"><?= $erro ?></div>
            <?php endif; ?>
            
            <br>

            <div class="nome_completo">
                <label for="usuario_id" class="input_label">Cliente</label>
                <select name="usuario_id" id="usuario_id" class="input_usuario" required>
                    <option value="">Selecione um cliente</option>
                    <?php while($usuario = mysqli_fetch_assoc($result_usuarios)): ?>
                        <option value="<?= $usuario['id'] ?>" 
                            <?= ($usuario['id'] == $pedido['usuario_id']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($usuario['nome']) ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
            <br><br>

            <div class="nome_completo">
                <input type="text" name="pedido" id="pedido" class="input_usuario" 
                       value="<?= htmlspecialchars($pedido['pedido']) ?>" required>
                <label for="pedido" class="input_label">Pedido</label>
            </div>
            <br><br>

            <div class="nome_completo">
                <input type="date" name="data_pedido" id="data_pedido" class="input_usuario" 
                       value="<?= $pedido['data_pedido'] ?>" required>
                <label for="data_pedido" class="input_label">Data do Pedido</label>
            </div>
            <br><br>

            <div class="nome_completo">
                <input type="text" name="endereco" id="endereco" class="input_usuario" 
                       value="<?= htmlspecialchars($pedido['endereco']) ?>" required>
                <label for="endereco" class="input_label">Endereço de Entrega</label>
            </div>
            <br><br>

            <input type="submit" name="botao" id="botao" value="Atualizar Pedido">
        </form>

        <a href="listarpedido.php" class="voltar-btn">Voltar para Lista de Pedidos</a>
    </div>
</body>
</html>