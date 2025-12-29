<?php
include_once 'connection/conn.php';

try {
    $conn->beginTransaction();

    $nome_completo = $_POST['nome_completo'];
    $email         = $_POST['email'];
    $password      = $_POST['password'];
    $cargo_id      = $_POST['cargo_id'];
    $data_admissao = $_POST['data_admissao'];

    // 1️⃣ Criar usuário
    $senhaHash = password_hash($password, PASSWORD_DEFAULT);

    $stmtUs = $conn->prepare(
        "INSERT INTO tb_us (nome_completo, email, password)
         VALUES (?, ?, ?)"
    );
    $stmtUs->execute([$nome_completo, $email, $senhaHash]);

    $us_id = $conn->lastInsertId();

    // 2️⃣ Criar funcionário
    $stmtFunc = $conn->prepare(
        "INSERT INTO tb_funcionario (us_id, cargo_id, data_admissao)
         VALUES (?, ?, ?)"
    );
    $stmtFunc->execute([$us_id, $cargo_id, $data_admissao]);

    $conn->commit();

    echo json_encode("Funcionário cadastrado com sucesso!");

} catch (Exception $e) {
    $conn->rollBack();
    echo json_encode("Erro ao cadastrar funcionário: " . $e->getMessage());
}
?>
