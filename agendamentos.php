<?php
require 'header.php';
require 'conexao.php';

if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit();
}

$usuario_id = $_SESSION['usuario_id'];
$role = $_SESSION['role'];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $role === 'user') {
    $data_agendamento = $_POST['data_agendamento'];
    $servico = $_POST['servico'];

    $sql = "INSERT INTO agendamentos (usuario_id, data_agendamento, servico) VALUES (:usuario_id, :data_agendamento, :servico)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['usuario_id' => $usuario_id, 'data_agendamento' => $data_agendamento, 'servico' => $servico]);

    $mensagem = "Agendamento realizado com sucesso!";
}

if ($role === 'admin') {
    // Administrador vê todos os agendamentos
    $sql = "SELECT agendamentos.*, usuarios.nome AS nome_usuario FROM agendamentos JOIN usuarios ON agendamentos.usuario_id = usuarios.id ORDER BY data_agendamento DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
} else {
    // Usuário comum vê apenas seus agendamentos
    $sql = "SELECT * FROM agendamentos WHERE usuario_id = :usuario_id ORDER BY data_agendamento DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['usuario_id' => $usuario_id]);
}
$agendamentos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container">
    <h2><?= $role === 'admin' ? 'Gerenciar' : 'Meus' ?> Agendamentos</h2>
    <?php if (isset($mensagem)): ?>
        <div class="alert alert-success"><?= $mensagem ?></div>
    <?php endif; ?>
    <?php if ($role === 'user'): ?>
    <form method="POST">
        <div class="form-group">
            <label>Data e Hora</label>
            <input type="datetime-local" name="data_agendamento" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Serviço</label>
            <input type="text" name="servico" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success">Agendar</button>
    </form>
    <?php endif; ?>

    <h3 class="mt-5"><?= $role === 'admin' ? 'Todos os' : 'Meus' ?> Agendamentos</h3>
    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>Data e Hora</th>
                <th>Serviço</th>
                <?php if ($role === 'admin'): ?>
                    <th>Usuário</th>
                    <th>Ações</th>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($agendamentos as $agendamento): ?>
                <tr>
                    <td><?= $agendamento['data_agendamento'] ?></td>
                    <td><?= $agendamento['servico'] ?></td>
                    <?php if ($role === 'admin'): ?>
                        <td><?= $agendamento['nome_usuario'] ?></td>
                        <td>
                            <a href="editar_agendamento.php?id=<?= $agendamento['id'] ?>" class="btn btn-primary">Editar</a>
                            <a href="deletar_agendamento.php?id=<?= $agendamento['id'] ?>" class="btn btn-danger" onclick="return confirm('Tem certeza que deseja deletar?')">Deletar</a>
                        </td>
                    <?php endif; ?>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <a href="logout.php" class="btn btn-danger">Sair</a>
</div>

<?php require 'footer.php'; ?>
