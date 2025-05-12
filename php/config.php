<?php

$dbHost = 'localhost';
$dbUsername = 'root';
$dbPassword = 'mysql';
$dbName = 'formulario-php';

$conexao=mysqli_connect($dbHost, $dbUsername, $dbPassword, $dbName);

if(!$conexao) {
    die("Houve um erro: ".mysqli_connect_errno());
}

