<?php
include_once 'connection/conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    try {
        $conn->beginTransaction();

        $paciente_id = $_POST['paciente_id'];
        $medico_id   = $_POST['medico_id'];
        $horario_id  = $_POST['horario_id'];
        $observacoes = $_POST['observacoes'] ?? '';

        $check = $conn->prepare(
            "SELECT COUNT(*) FROM tb_consulta
             WHERE medico_id = ? AND horario_id = ? AND status = 'Agendada'"
        );
        $check->execute([$medico_id, $horario_id]);

        if ($check->fetchColumn() > 0) {
            throw new Exception("Horário indisponível para este médico.");
        }

     
        $stmt = $conn->prepare(
            "INSERT INTO tb_consulta
             (paciente_id, medico_id, horario_id, observacoes, status)
             VALUES (?, ?, ?, ?, 'Agendada')"
        );
        $stmt->execute([
            $paciente_id,
            $medico_id,
            $horario_id,
            $observacoes
        ]);

        $conn->commit();
        echo json_encode("Consulta agendada com sucesso!");

    } catch (Exception $e) {
        $conn->rollBack();
        echo json_encode("Erro ao agendar consulta: " . $e->getMessage());
    }
}
?>
