<?php
include 'config.php';

$sql = "SELECT p.id, u.nome as cliente, p.pedido, p.data_pedido, p.endereco, p.total 
        FROM pedidos p
        JOIN usuarios u ON p.usuario_id = u.id
        ORDER BY p.data_pedido DESC";

$result = $conexao->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedidos Listados</title>
    <link rel="stylesheet" href="css/listarpedidos.css?v=1.0">
</head>
<body>
    <h1 class="header">Pedidos cadastrados</h1>
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Cliente</th>
                    <th>Itens do Pedido</th>
                    <th>Total</th>
                    <th>Data</th>
                    <th>Endereço</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        
                        $itens = explode(", ", $row["pedido"]);
                        
                        echo "<tr>
                            <td>" . $row["id"] . "</td>
                            <td>" . htmlspecialchars($row["cliente"]) . "</td>
                            <td class='itens-pedido'>";
                            
                            
                            foreach ($itens as $item) {
                                echo "<span class='item-pedido'>" . htmlspecialchars($item) . "</span>";
                            }
                            
                        echo "</td>
                            <td>R$ " . number_format($row["total"], 2, ',', '.') . "</td>
                            <td>" . $row["data_pedido"] . "</td>
                            <td>" . htmlspecialchars($row["endereco"]) . "</td>
                            <td class='action-buttons'>
                                <form action='editarpedido.php' method='GET' style='display: inline;'>
                                    <input type='hidden' name='id' value='" . $row["id"] . "'>
                                    <button type='submit' class='edit-button' title='Editar'>
                                        <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-pencil-fill' viewBox='0 0 16 16'>
                                            <path d='M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.5.5 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11z'/>
                                        </svg>
                                    </button>
                                </form>
                                <form action='excluirpedido.php' method='POST' onsubmit='return confirm(\"Tem certeza que deseja excluir este pedido?\");' style='display: inline;'>
                                    <input type='hidden' name='id' value='" . $row["id"] . "'>
                                    <button type='submit' class='btn-excluir' title='Excluir'>
                                        <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-x-circle' viewBox='0 0 16 16'>
                                            <path d='M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16'/>
                                            <path d='M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708'/>
                                        </svg>
                                    </button>
                                </form>
                            </td>
                        </tr>";
                    }
                } else {
                    echo "<tr><td colspan='7'>Nenhum pedido encontrado</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
    <button onclick="window.location.href='telainicial.html'" class="voltar">Voltar</button>
</body>
</html> 