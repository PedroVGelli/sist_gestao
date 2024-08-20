<?php
require 'header.php';
require 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $telefone = $_POST['telefone'];
    $email = $_POST['email'];

    $sql = "INSERT INTO clientes (nome, telefone, email) VALUES (:nome, :telefone, :email)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['nome' => $nome, 'telefone' => $telefone, 'email' => $email]);

    header('Location: index.php');
}

?>

<div class="container">
    <h2>Adicionar Novo Cliente</h2>
    <form method="POST">
        <div class="form-group">
            <label>Nome</label>
            <input type="text" name="nome" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Telefone</label>
            <input type="text" name="telefone" class="form-control">
        </div>
        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" class="form-control">
        </div>
        <button type="submit" class="btn btn-success">Salvar</button>
    </form>
</div>

<?php require 'footer.php'; ?>
