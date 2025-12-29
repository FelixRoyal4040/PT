<?php
  include_once 'connection/conn.php';

  $nome_completo = $_POST['nome_completo'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $cargo = $_POST['cargo'];
  $data_admissao = $_POST['data_admissao'];

  $cargos = [];
  $cargo_id = $cargos[$cargo];

  $stmt1 = $conn->prepare("INSERT INTO tb_us (email, password) VALUES (?,?)");
  $stmt2 = $conn->prepare("INSERT INTO tb_funcionario (nome_completo, cargo_id, data_admissao) VALUES (?,?,?)");

  $stmt1->execute([$email, $password]);
  $stmt2->execute([$nome_completo, $cargo_id, $data_admissao]);

  echo json_encode("Funcionário cadastrado com sucesso!");

?>