<?php
  include_once 'connection/conn.php';

  $data_consulta = $_POST['data'];
  $hora_inicio = $_POST['hora_inicio'];
  $hora_fim = $_POST['hora_fim'];
  $medico_id = $_POST['medico_id'];

  $disponibilidade = true || false; // Rever com urgência
  // Disponibilidade pertence ao médico ou à consulta?

  if($disponibilidade == true){
    $stmt = $conn->prepare("INSERT INTO tb_horarios (data, hora_inicio, hora_fim, medico_id) VALUES (?,?,?,?)");
    $stmt->execute([$data_consulta, $hora_inicio, $hora_fim, $medico_id]);
    echo json_encode("Horário cadastrado com sucesso!");
  }else{
    echo json_encode("Médico indisponível!");
  }
?>