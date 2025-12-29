<?php
include_once 'connection/conn.php';

try {
    $conn->beginTransaction();

    $nome_completo   = $_POST['nome'];
    $data_nascimento = $_POST['data_nascimento'];
    $sexo            = $_POST['sexo'];
    $telefone        = $_POST['telefone'];
    $email           = $_POST['email'];
    $password        = $_POST['password'];

    // 1️⃣ Criar usuário
    $senhaHash = password_hash($password, PASSWORD_DEFAULT);

    $stmtUs = $conn->prepare(
        "INSERT INTO tb_us (email, password) VALUES (?, ?)"
    );
    $stmtUs->execute([$email, $senhaHash]);

    $us_id = $conn->lastInsertId();

    // 2️⃣ Criar paciente
    $stmtPaciente = $conn->prepare(
        "INSERT INTO tb_paciente (us_id, nome_completo, data_nascimento, sexo, telefone)
         VALUES (?, ?, ?, ?, ?)"
    );
    $stmtPaciente->execute([
        $us_id,
        $nome_completo,
        $data_nascimento,
        $sexo,
        $telefone
    ]);

    $conn->commit();
    echo "Paciente cadastrado com sucesso!";

} catch (Exception $e) {
    $conn->rollBack();
    echo "Erro ao cadastrar paciente: " . $e->getMessage();
}
?>
