<?php
require 'header.php';
require 'conexao.php';
session_start();

if (!isset($_SESSION['usuario_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

$sql = "SELECT * FROM usuarios
