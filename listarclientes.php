<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clientes Listados</title>
    <link rel="stylesheet" href="css/listarclientes.css?v=1.0">
</head>
<body>
    <h1 class="header">Clientes cadastrados</h1>
    <div class="table-container">
       
            <tbody>
            <?php
            include ("listar.php");
            ?>

            </tbody>
    </div>
    <button onclick="window.location.href='telainicial.html'" class="voltar">Voltar</button>

</body>
</html>
