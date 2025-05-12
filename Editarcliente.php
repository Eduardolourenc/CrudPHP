<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Pedido</title>
    <link rel="stylesheet" href="css/pedidolistado.css?v=1.0">
</head>
<body class="page-body">
    <tbody class="hidden-content">
        <?php 
        include("editar.php");
        ?>
    </tbody>
    <h1 class="page-title">Editar cliente</h1>
    <form class="edit-form" method="POST" action="">
        <div class="form-group">
            <label for="nome" class="form-label">Nome:</label>
            <input type="text" id="nome" name="nome" class="form-input" value="<?= htmlspecialchars($pedido['nome']) ?>" required>
        </div>
        
        <div class="form-group">
            <label for="telefone" class="form-label">Telefone:</label>
            <input type="text" id="telefone" name="telefone" class="form-input" value="<?= htmlspecialchars($pedido['telefone']) ?>" required>
        </div>
        
        <button type="submit" class="form-button">Salvar</button>
    </form>
</body>
</html>
