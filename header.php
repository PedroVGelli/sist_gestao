<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciador de Barbearia</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
</head>
<body>
<?php
session_start();
if (isset($_SESSION['usuario_id'])) {
    echo '<nav class="navbar navbar-light bg-light"><span class="navbar-text">Bem-vindo, ' . $_SESSION['nome'] . '</span></nav>';
}
?>
