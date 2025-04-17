<?php
include 'conexao.php';

$nome = $_POST['nome'];
$email = $_POST['email'];
$telefone = $_POST['telefone'];
$empresa = $_POST['empresa'];

$sql = "INSERT INTO leads (nome, email, telefone, empresa, status) VALUES (?, ?, ?, ?, 'Novo')";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssss", $nome, $email, $telefone, $empresa);
$stmt->execute();
$stmt->close();
$conn->close();

header("Location: index.php");
exit();
?>
