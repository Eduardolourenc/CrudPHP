<?php
include("config.php");

// Buscar usuários
$sql_usuarios = "SELECT id, nome FROM usuarios";
$result_usuarios = mysqli_query($conexao, $sql_usuarios);

// Opções de pedido pré-definidas
$opcoes_pedido = [
    "Hambúrguer Simples" => 15.00,
    "Hambúrguer Duplo" => 22.00,
    "Pizza Calabresa" => 35.00,
    "Pizza Mussarela" => 32.00,
    "Batata Frita Pequena" => 10.00,
    "Batata Frita Grande" => 15.00,
    "Refrigerante Lata" => 5.00,
    "Refrigerante 600ml" => 7.00,
    "Refrigerante 1L" => 9.00,
    "Suco Natural" => 8.00,
    "Água Mineral" => 3.50
];

$edicao = false;
$pedido_atual = null;

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $sql_pedido = "SELECT * FROM pedidos WHERE id = $id";
    $result_pedido = mysqli_query($conexao, $sql_pedido);
    
    if ($result_pedido->num_rows > 0) {
        $pedido_atual = $result_pedido->fetch_assoc();
        $edicao = true;
        $itens_selecionados = explode(", ", $pedido_atual['pedido']);
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario_id = $_POST["usuario_id"];
    $itens_pedido = isset($_POST["itens_pedido"]) ? $_POST["itens_pedido"] : [];
    $data_pedido = $_POST["data_pedido"];
    $endereco = $_POST["endereco"];
    
    
    $pedido_str = implode(", ", $itens_pedido);
    
   
    $total = 0;
    foreach ($itens_pedido as $item) {
        if (isset($opcoes_pedido[$item])) {
            $total += $opcoes_pedido[$item];
        }
    }

    if ($edicao) {
        $id = $pedido_atual['id'];
        $sql = "UPDATE pedidos SET 
                usuario_id = '$usuario_id', 
                pedido = '$pedido_str', 
                data_pedido = '$data_pedido', 
                endereco = '$endereco',
                total = '$total'
                WHERE id = $id";
    } else {
        $sql = "INSERT INTO pedidos(usuario_id, pedido, data_pedido, endereco, total) 
                VALUES ('$usuario_id', '$pedido_str', '$data_pedido', '$endereco', '$total')";
    }

    if (mysqli_query($conexao, $sql)) {
        header("Location: cadastrorealizado.html");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conexao);
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $edicao ? 'Editar' : 'Cadastrar' ?> Pedido</title>
    <link rel="stylesheet" href="css/cadastrarpedido.css">
    
</head>

<body>
    <div class="container">
        <form action="cadastrarpedido.php<?= $edicao ? '?id='.$pedido_atual['id'] : '' ?>" method="POST">
            <fieldset class="header">
                <legend class="legenda"><b><?= $edicao ? 'Editar' : 'Cadastrar' ?> Pedido</b></legend>
            </fieldset>
            <br>

            <div class="nome_completo">
                <label for="usuario_id" class="input_label">Cliente:</label>
                <select name="usuario_id" id="usuario_id" class="input_usuario" required>
                    <option value="">Selecione um cliente</option>
                    <?php 
                    mysqli_data_seek($result_usuarios, 0);
                    while ($row = mysqli_fetch_assoc($result_usuarios)): ?>
                        <option value="<?= $row['id'] ?>" 
                            <?= ($edicao && $row['id'] == $pedido_atual['usuario_id']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($row['nome']) ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
            <br><br>

            <div class="nome_completo">
                <label class="input_label">Itens do Pedido:</label>
                <div class="itens-container">
                    <?php foreach($opcoes_pedido as $item => $preco): ?>
                        <div class="item-option">
                            <input type="checkbox" name="itens_pedido[]" id="item_<?= md5($item) ?>" 
                                   value="<?= htmlspecialchars($item) ?>"
                                   <?= ($edicao && in_array($item, $itens_selecionados)) ? 'checked' : '' ?>>
                            <label for="item_<?= md5($item) ?>" class="item-info">
                                <span><?= htmlspecialchars($item) ?></span>
                                <span>R$ <?= number_format($preco, 2, ',', '.') ?></span>
                            </label>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <br><br>

            <div class="nome_completo">
                <input type="date" name="data_pedido" id="data_pedido" class="input_usuario" 
                    value="<?= $edicao ? $pedido_atual['data_pedido'] : '' ?>" required>
                <label for="data_pedido" class="input_label">Data do Pedido</label>
            </div>
            <br><br>

            <div class="nome_completo">
                <input type="text" name="endereco" id="endereco" class="input_usuario" 
                    value="<?= $edicao ? htmlspecialchars($pedido_atual['endereco']) : '' ?>" required>
                <label for="endereco" class="input_label">Endereço de Entrega</label>
            </div>
            <br><br>

            <input type="submit" name="botao" id="botao" value="<?= $edicao ? 'Atualizar' : 'Cadastrar' ?> Pedido">
        </form>

        <a href="listarpedido.php" class="listados">Ver Pedidos Cadastrados</a>
        <a href="telainicial.html" class="telainicial">Voltar a tela inicial</a>
    </div>
</body>
</html>