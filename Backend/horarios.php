<?php
include_once 'connection/conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    try {
        $data_consulta = $_POST['data'];
        $hora_inicio   = $_POST['hora_inicio'];
        $hora_fim      = $_POST['hora_fim'];
        $medico_id     = $_POST['medico_id'];

        // 1️⃣ Verificar conflito de horário
        $check = $conn->prepare(
            "SELECT COUNT(*) FROM tb_horario
             WHERE medico_id = ?
             AND data = ?
             AND (
                 (? BETWEEN hora_inicio AND hora_fim)
                 OR
                 (? BETWEEN hora_inicio AND hora_fim)
             )"
        );
        $check->execute([
            $medico_id,
            $data_consulta,
            $hora_inicio,
            $hora_fim
        ]);

        if ($check->fetchColumn() > 0) {
            throw new Exception("Conflito de horário para este médico.");
        }

        // 2️⃣ Inserir horário como LIVRE
        $stmt = $conn->prepare(
            "INSERT INTO tb_horario
             (medico_id, data, hora_inicio, hora_fim, status)
             VALUES (?, ?, ?, ?, 'Livre')"
        );
        $stmt->execute([
            $medico_id,
            $data_consulta,
            $hora_inicio,
            $hora_fim
        ]);

        echo json_encode("Horário cadastrado com sucesso!");

    } catch (Exception $e) {
        echo json_encode("Erro: " . $e->getMessage());
    }
}
?>
