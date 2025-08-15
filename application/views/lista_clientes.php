<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <title>Lista de Clientes</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="../../style.css" rel="stylesheet">
</head>
<body class="d-flex min-vh-100 bg-light text-dark">
<?php include __DIR__.'/navbar.php'; ?>
<?php include __DIR__.'/sidebar.php'; ?>
<div class="container mt-5">
  <h3>Lista de Clientes</h3>
  <table class="table table-striped table-hover align-middle">
    <thead class="table-light">
      <tr>
        <th>#</th><th>Nome</th><th>Email</th>
      </tr>
    </thead>
    <tbody>
    <?php foreach (($dataVar['clientes'] ?? []) as $c): ?>
      <tr>
        <td><?= $c['id']; ?></td>
        <td><?= $c['nome']; ?></td>
        <td><?= $c['email']; ?></td>
      </tr>
    <?php endforeach; ?>
    </tbody>
  </table>
</div>
</body>
</html>
