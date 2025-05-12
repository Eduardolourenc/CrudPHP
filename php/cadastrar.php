<?php 

include("config.php");

$nome=$_POST["nome"];
$telefone=$_POST["telefone"];

$sql="INSERT INTO usuarios(nome,telefone) values ('$nome', '$telefone')";


if(mysqli_query($conexao, $sql)){
    include 'cadastrorealizado.html';
} else {
    echo("Error:" .$sql. "<br>" .mysqli_error($conexao));
}

?>