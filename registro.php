<?php
require 'header.php';
require 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = password_hash($_POST['senha'], PASSWORD_BCRYPT);
    $role = 'user'; // Define o papel padrão como usuário

    $sql = "INSERT INTO usuarios (nome, email, senha, role) VALUES (:nome, :email, :senha, :role)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['nome' => $nome, 'email' => $email, 'senha' => $senha, 'role' => $role]);

    header('Location: login.php');
}
?>

<div class="container">
    <h2>Registrar-se</h2>
    <form method="POST">
        <div class="form-group">
            <label>Nome</label>
            <input type="text" name="nome" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Senha</label>
            <input type="password" name="senha" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success">Registrar</button>
    </form>
</div>

<?php require 'footer.php'; ?>
