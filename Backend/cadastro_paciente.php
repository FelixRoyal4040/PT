<?php
  include_once 'connection/conn.php';

  $nome_completo = $_POST['nome'];
  $data_nascimento = $_POST['data_nascimento'];
  $sexo = $_POST['sexo'];
  $telefone = $_POST['telefone'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  
  
  $stmt = $conn->prepare("INSERT INTO tb_pacientes (nome_completo, data_nascimento, sexo, telefone, email, password) VALUES (?,?,?,?,?,?)");

  $stmt->execute([$nome_completo, $data_nascimento, $sexo, $telefone, $email, $password]);

  echo "Paciente cadastrado com sucesso!";
?>