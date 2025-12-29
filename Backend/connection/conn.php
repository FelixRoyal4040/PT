<?php
  $conn = new PDO("mysql:host=localhost;dbname=teste_sac", "root", "");
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>