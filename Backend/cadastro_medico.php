<?php
include_once 'connection/conn.php';

try {
    $conn->beginTransaction();

    $email           = $_POST['email'];
    $password        = $_POST['password'];
    $cargo_id        = $_POST['cargo_id'];
    $data_admissao   = $_POST['data_admissao'];
    $crm             = $_POST['crm'];
    $especialidade_id = $_POST['especialidade_id'];

    // 1️⃣ Criar usuário
    $senhaHash = password_hash($password, PASSWORD_DEFAULT);

    $stmtUs = $conn->prepare(
        "INSERT INTO tb_us (email, password) VALUES (?, ?)"
    );
    $stmtUs->execute([$email, $senhaHash]);

    $us_id = $conn->lastInsertId();

    // 2️⃣ Criar funcionário
    $stmtFunc = $conn->prepare(
        "INSERT INTO tb_funcionario (us_id, cargo_id, data_admissao)
         VALUES (?, ?, ?)"
    );
    $stmtFunc->execute([$us_id, $cargo_id, $data_admissao]);

    $funcionario_id = $conn->lastInsertId();

    // 3️⃣ Criar médico
    $stmtMedico = $conn->prepare(
        "INSERT INTO tb_medico (funcionario_id, crm)
         VALUES (?, ?)"
    );
    $stmtMedico->execute([$funcionario_id, $crm]);

    $medico_id = $conn->lastInsertId();

    // 4️⃣ Associar especialidade
    $stmtEsp = $conn->prepare(
        "INSERT INTO tb_medico_especialidade (medico_id, especialidade_id)
         VALUES (?, ?)"
    );
    $stmtEsp->execute([$medico_id, $especialidade_id]);

    $conn->commit();

    echo json_encode("Médico cadastrado com sucesso!");

} catch (Exception $e) {
    $conn->rollBack();
    echo json_encode("Erro: " . $e->getMessage());
}
?>
