<?php
	include_once 'connection/conn.php';
	header('Content-Type: application/json');

	$input = file_get_contents("php://input");
	$data = json_decode($input, true);

	try {
		$conn->beginTransaction();

		$nome_completo= $data['name'];
		$speciality= $data['speciality'];
		$email= $data['email'];
		$phone= $data['phone'];

		$search = $conn->prepare("SELECT id FROM tb_especialidade WHERE nome = ?");
		$search->execute([$speciality]);
		$especialidade = $search->fetch(PDO::FETCH_ASSOC);

		if (!$especialidade) {
				throw new Exception("Especialidade não encontrada");
		}

		$speciality_id = $especialidade['id'];

		$senha_padrao = password_hash("123456", PASSWORD_DEFAULT);

		$insert = $conn->prepare("INSERT INTO tb_us (email, password) VALUES (?, ?)");
		$insert->execute([$email, $senha_padrao]);

		$us_id = $conn->lastInsertId();

		$insert = $conn->prepare("INSERT INTO tb_funcionario (us_id, nome_completo, telefone,  cargo_id) VALUES (?, ?, ?, 2)");
		$insert->execute([$us_id, $nome_completo, $phone]);

		$funcionario_id = $conn->lastInsertId();

		$insert = $conn->prepare("INSERT INTO tb_medico (funcionario_id) VALUES (?)");

		$insert->execute([$funcionario_id]);

		$medico_id = $conn->lastInsertId();

		$insert = $conn->prepare("INSERT INTO tb_medico_especialidade (medico_id, especialidade_id) VALUES (?, ?)");
		$insert->execute([$medico_id, $speciality_id]);

		$conn->commit();

		echo json_encode([
				'success' => true,
				'message' => 'Médico cadastrado com sucesso!'
		]);

	} catch (Exception $e) {
		$conn->rollBack();
		echo json_encode([
				'success' => false,
				'message' => $e->getMessage()
		]);
	}
?>