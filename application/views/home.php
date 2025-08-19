<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Painel de Controle | SIGE</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link href="<?= base_url('assets/style.css'); ?>" rel="stylesheet">  
</head>
<body class="d-flex min-vh-100 bg-light text-dark">
<?php $this->load->view('navbar'); ?>
<?php $this->load->view('sidebar'); ?>
<div class="content">
  <div class="row mb-4">
    <div class="col-md-4 mb-3">
      <div class="card text-white bg-gradient-primary shadow-sm">
        <div class="card-body d-flex align-items-center">
          <i class="bi bi-wallet2 fs-1 me-3"></i>
          <div>
            <h6 class="card-title">Saldo da Conta</h6>
            <h4>Kz 120.000</h4>
            <a href="#" class="text-white-50 small">Ver detalhes</a>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-4 mb-3">
      <div class="card text-white bg-gradient-success shadow-sm">
        <div class="card-body d-flex align-items-center">
          <i class="bi bi-people-fill fs-1 me-3"></i>
          <div>
            <h6 class="card-title">Clientes Ativos</h6>
            <h4>174</h4>
            <a href="#" class="text-white-50 small">Ver lista</a>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-4 mb-3">
      <div class="card text-white bg-gradient-warning shadow-sm">
        <div class="card-body d-flex align-items-center">
          <i class="bi bi-cart-check fs-1 me-3"></i>
          <div>
            <h6 class="card-title">Vendas do Mês</h6>
            <h4>Kz 72.000</h4>
            <a href="#" class="text-white-50 small">Detalhes</a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="chart-container mt-3 bg-white text-dark">
    <h5 class="mb-3">Gráfico de Vendas (Mensal)</h5>
    <canvas id="vendasChart" height="100"></canvas>
  </div>

  <div class="table-responsive mt-4">
    <h5 class="mb-3">Últimos Clientes</h5>
    <table class="table table-striped table-hover align-middle">
      <thead class="table-light">
          <tr>
            <th>#</th>
            <th>Nome</th>
            <th>Telefone</th>
            <th>Endereço</th>
            <th>Data</th>
            <th>Status</th>
            <th>Ações</th>
          </tr>
      </thead>
      <tbody>
        <tr>
          <td>1</td>
          <td>João Silva</td>
          <td>999999999</td>
          <td>Rua A, 123</td>
          <td>01/08/2025</td>
          <td><span class="badge bg-success">Ativo</span></td>
          <td>
            <button class="btn btn-sm btn-outline-primary me-1"><i class="bi bi-pencil-square"></i></button>
            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="<?= base_url('assets/script.js'); ?>"></script>
<script src="<?= base_url('assets/layout.js'); ?>"></script>
</body>
</html>
