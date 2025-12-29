<?php
  include_once 'connection/conn.php';

  header('Content-Type: application/json');

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
      $input = file_get_contents("php://input");
      $data = json_decode($input, true);

      if (!isset($data['email'], $data['password'])) {
        throw new Exception("Dados incompletos.");
      }

      $email = $data['email'];
      $password = $data['password'];

      $stmt = $conn->prepare("SELECT * FROM tb_us WHERE email = ?");
      $stmt->execute([$email]);
      $user = $stmt->fetch(PDO::FETCH_ASSOC);

      if ($user && password_verify($password, $user['password'])) {
        echo json_encode([
          "success" => true,
          "message" => "Login bem-sucedido"
        ]);
      } else {
        echo json_encode([
          "success" => false,
          "message" => "Email ou senha inválidos"
        ]);
      }

    } catch (Exception $e) {
      echo json_encode([
        "success" => false,
        "message" => $e->getMessage()
      ]);
    }
  }
?>