<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Saídas | SIGE</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link href="<?= base_url('assets/style.css'); ?>" rel="stylesheet">
</head>
<body class="d-flex min-vh-100 bg-light text-dark">
<?php $this->load->view('navbar'); ?>
<?php $this->load->view('sidebar'); ?>
<div class="content">
  <div class="container mt-5">
    <h3>Saídas</h3>
    <div class="table-responsive">
      <table class="table table-striped">
        <thead>
          <tr>
            <th>Data</th>
            <th>Descrição</th>
            <th>Valor (Kz)</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($saidas as $s): ?>
          <tr>
            <td><?= date('d/m/Y', strtotime($s->data)); ?></td>
            <td><?= htmlspecialchars($s->descricao, ENT_QUOTES, 'UTF-8'); ?></td>
            <td><?= number_format($s->valor, 2, ',', '.'); ?></td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?= base_url('assets/layout.js'); ?>"></script>
</body>
</html>
