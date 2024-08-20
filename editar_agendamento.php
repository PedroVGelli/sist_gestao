<?php
require 'header.php';
require 'conexao.php';

if (!isset($_SESSION['usuario_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

$id = $_GET['id'];
$sql = "SELECT * FROM agendamentos WHERE id = :id";
$stmt = $pdo->prepare($sql);
$stmt->execute(['id' => $id]);
$agendamento = $stmt->fetch(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data_agendamento = $_POST['data_agendamento'];
    $servico = $_POST['servico'];

    $sql = "UPDATE agendamentos SET data_agendamento = :data_agendamento, servico = :servico WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['data_agendamento' => $data_agendamento, 'servico' => $servico, 'id' => $id]);

    header('Location: agendamentos.php');
}

?>

<div class="container">
    <h2>Editar Agendamento</h2>
    <form method="POST">
        <div class="form-group">
            <label>Data e Hora</label>
            <input type="datetime-local" name="data_agendamento" class="form-control" value="<?= $agendamento['data_agendamento'] ?>" required>
        </div>
        <div class="form-group">
            <label>Serviço</label>
            <input type="text" name="servico" class="form-control" value="<?= $agendamento['servico'] ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Atualizar</button>
    </form>
</div>

<?php require 'footer.php'; ?>
