<?php include 'conexao.php'; ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Mini CRM - Leads</title>
  <style>
    body { font-family: Arial; padding: 20px; background: #f2f2f2; }
    h2 { color: #333; }
    form, table, .dashboard { background: white; padding: 20px; border-radius: 8px; }
    table { width: 100%; margin-top: 20px; border-collapse: collapse; }
    th, td { padding: 10px; border: 1px solid #ccc; }
    th { background: #eee; }
    .dashboard { display: flex; justify-content: space-around; margin-bottom: 20px; }
    .card { flex: 1; margin: 0 10px; padding: 15px; border-radius: 10px; color: white; text-align: center; font-weight: bold; }
    .novo { background: #f1c40f; }
    .negociacao { background: #e67e22; }
    .fechado { background: #2ecc71; }
  </style>
</head>
<body>
<h2>Resumo dos Leads</h2>
<div class="dashboard">
  <?php
    $novo = $conn->query("SELECT COUNT(*) as total FROM leads WHERE status='Novo'")->fetch_assoc()['total'];
    $negociacao = $conn->query("SELECT COUNT(*) as total FROM leads WHERE status='Em negociação'")->fetch_assoc()['total'];
    $fechado = $conn->query("SELECT COUNT(*) as total FROM leads WHERE status='Fechado'")->fetch_assoc()['total'];
  ?>
  <div class="card novo">🟡 Novo<br><?php echo $novo; ?></div>
  <div class="card negociacao">🟠 Em negociação<br><?php echo $negociacao; ?></div>
  <div class="card fechado">🟢 Fechado<br><?php echo $fechado; ?></div>
</div>

<h2>Cadastro de Leads</h2>
<form action="cadastrar.php" method="POST">
  <label>Nome:</label><br>
  <input type="text" name="nome" required><br>
  <label>E-mail:</label><br>
  <input type="email" name="email" required><br>
  <label>Telefone:</label><br>
  <input type="text" name="telefone" required><br>
  <label>Empresa:</label><br>
  <input type="text" name="empresa" required><br><br>
  <button type="submit">Cadastrar Lead</button>
</form>

<h2>Lista de Leads</h2>
<table>
  <tr>
    <th>Nome</th><th>Email</th><th>Telefone</th><th>Empresa</th><th>Status</th><th>Ação</th>
  </tr>
  <?php
  $sql = "SELECT * FROM leads ORDER BY id DESC";
  $result = $conn->query($sql);
  while($row = $result->fetch_assoc()) {
    echo "<tr>
      <td>{$row['nome']}</td>
      <td>{$row['email']}</td>
      <td>{$row['telefone']}</td>
      <td>{$row['empresa']}</td>
      <td>{$row['status']}</td>
      <td>
        <form action='atualizar.php' method='POST' style='display:inline;'>
          <input type='hidden' name='id' value='{$row['id']}'>
          <select name='status'>
            <option value='Novo'" . ($row['status'] == 'Novo' ? ' selected' : '') . ">Novo</option>
            <option value='Em negociação'" . ($row['status'] == 'Em negociação' ? ' selected' : '') . ">Em negociação</option>
            <option value='Fechado'" . ($row['status'] == 'Fechado' ? ' selected' : '') . ">Fechado</option>
          </select>
          <button type='submit'>Atualizar</button>
        </form>
      </td>
    </tr>";
  }
  ?>
</table>
</body>
</html>