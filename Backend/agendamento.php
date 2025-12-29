<?php
  include_once 'connection/conn.php';
  /*
  $nome_paciente = $_POST['paciente_id'];
  $nome_medico = $_POST['medico_id']; // Rever com urgência
  $data_consulta = $_POST['horario_id'];
  $observacoes = $_POST['observacoes'] ?? '';
  $estado_consulta = '';

  if(){
    $estado_consulta = 'Agendada';
  }else if(){
    $estado_consulta = 'Concluída';
  }else{
    $estado_consulta = 'Cancelada';
  }


  $stmt = $conn->prepare("INSERT INTO tb_agendamentos (paciente_id, medico_id, horario_id, observacoes, estado_consulta) VALUES (?,?,?,?,?)");
  $stmt->execute([$nome_paciente, $nome_medico, $data_consulta, $observacoes, $estado_consulta]);

  if($estado_consulta == 'Agendada'){
    echo json_encode("Consulta agendada com sucesso!");
  }else if($estado_consulta == 'Concluída'){
    echo json_encode("Consulta concluída com sucesso!");  
  }else{
    echo json_encode("Consulta cancelada com sucesso!");
  }*/

  if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $paciente_id = $_POST['paciente_id'];
    $medico_id = $_POST['medico_id'];
    $horario_id = $_POST['horario_id'];
    $observacoes = $_POST['observacoes'] ?? '';
    $estado_consulta = $_POST['estado_consulta'];

    $stmt = $conn->prepare("INSERT INTO tb_agendamentos (paciente_id, medico_id, horario_id, observacoes, estado_consulta) VALUES (?,?,?,?,?)");
    $stmt->execute([$paciente_id, $medico_id, $horario_id, $observacoes, $estado_consulta]);

    switch($estado_consulta){
      case 'Agendada':
        echo json_encode("Consulta agendada com sucesso!");
        break;
      case 'Concluída':
        echo json_encode("Consulta concluída com sucesso!");
        break;
      case 'Cancelada':
        echo json_encode("Consulta cancelada com sucesso!");
        break;
      default:
        echo json_encode("Estado da consulta inválido!");
        break;
    }

  }
    
?>