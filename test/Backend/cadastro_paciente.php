<?php
    include_once 'connection/conn.php';

    header('Content-Type: application/json');
    $input = file_get_contents("php://input");
    $data = json_decode($input, true);

    try{
        $conn->beginTransaction();

        $nome_completo= $data['name'];
        $data_nascimento= $data['data_nasc'];
        $sexo= $data['gender'];
        $telefone= $data['phone'];
        $email= $data['email'];
        $password= $data['password'];

        $senhaHash = password_hash($password, PASSWORD_DEFAULT);

        $stmtUs = $conn->prepare("INSERT INTO tb_us (email, password) VALUES (?, ?)");
        $stmtUs->execute([$email, $senhaHash]);

        $us_id = $conn->lastInsertId();

        $stmtPaciente = $conn->prepare("INSERT INTO tb_paciente (us_id, nome_completo, data_nascimento, sexo, telefone) VALUES (?, ?, ?, ?, ?)");
        
        $stmtPaciente->execute([
            $us_id,
            $nome_completo,
            $data_nascimento,
            $sexo,
            $telefone
        ]);

        $conn->commit();
        echo json_encode([
            "success" => true,
            "message" => "Paciente cadastrado com sucesso!"
        ]);

    } catch (Exception $e) {
        $conn->rollBack();
        echo json_encode([
            "success" => false,
            "message" => "Erro ao cadastrar paciente: " . $e->getMessage()
        ]);
    }
?>
