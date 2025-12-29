<?php
    include_once 'connection/conn.php';

    header('Content-Type: application/json');
    $input = file_get_contents("php://input");
    $data = json_decode($input, true);

    try{
        $conn->beginTransaction();

        $nome_completo= $data['name'];
        $telefone= $data['phone'];
        $email= $data['email'];
        $password= $data['password'];
        $charge = $data['charge'];

        $senhaHash = password_hash($password, PASSWORD_DEFAULT);

        $search = $conn->prepare("SELECT id FROM tb_cargo WHERE nome = ?");
		$search->execute([$charge]);
		$cargo = $search->fetch(PDO::FETCH_ASSOC);

		if (!$cargo) {
		    throw new Exception("Cargo não encontrado!");
		}

		$charge_id = $cargo['id'];

        $stmtUs = $conn->prepare("INSERT INTO tb_us (email, password) VALUES (?, ?)");
        $stmtUs->execute([$email, $senhaHash]);

        $us_id = $conn->lastInsertId();

        $stmtFuncionario = $conn->prepare("INSERT INTO tb_funcionario (us_id, nome_completo, telefone,  cargo_id) VALUES (?, ?, ?, ?)");
		$stmtFuncionario->execute([$us_id, $nome_completo, $phone, $charge_id]);
        
        $conn->commit();
        echo json_encode([
            "success" => true,
            "message" => "Funcionario cadastrado com sucesso!"
        ]);

    } catch (Exception $e) {
        $conn->rollBack();
        echo json_encode([
            "success" => false,
            "message" => "Erro ao cadastrar funcionario: " . $e->getMessage()
        ]);
    }
?>
