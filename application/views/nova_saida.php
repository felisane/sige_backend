<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Registrar Saída | SIGE</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link href="<?= base_url('assets/style.css'); ?>" rel="stylesheet">
  <style>
    .toast { position: fixed; top: 20px; right: 20px; z-index: 9999; }
  </style>
</head>
<body class="d-flex min-vh-100 bg-light text-dark">
<?php $this->load->view('navbar'); ?>
<?php $this->load->view('sidebar'); ?>
<div class="content">
  <div class="container-fluid">
    <h4 class="mb-4">Registrar Saída</h4>
    <div class="card shadow-sm">
      <div class="card-body">
        <form id="saidaForm">
          <div class="mb-3">
            <label for="dataSaida" class="form-label">Data</label>
            <input type="date" class="form-control" id="dataSaida" name="data" required>
          </div>
          <div class="mb-3">
            <label for="descricaoSaida" class="form-label">Descrição</label>
            <input type="text" class="form-control" id="descricaoSaida" name="descricao" required>
          </div>
          <div class="mb-3">
            <label for="valorSaida" class="form-label">Valor (Kz)</label>
            <input type="number" step="0.01" class="form-control" id="valorSaida" name="valor" required>
          </div>
          <div class="mb-3">
            <label for="formaPagamentoSaida" class="form-label">Forma de Pagamento</label>
            <select class="form-select" id="formaPagamentoSaida" name="forma_pagamento" required>
              <option value="TPA">TPA</option>
              <option value="CASH">CASH</option>
              <option value="Cartão Weza">Cartão Weza</option>
              <option value="Cartão Sérgio">Cartão Sérgio</option>
              <option value="Outro">Outro</option>
            </select>
          </div>
          <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Registrar Saída</button>
        </form>
      </div>
    </div>
  </div>
</div>

<div id="toast-success" class="toast align-items-center text-bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true" style="display:none;">
  <div class="d-flex">
    <div class="toast-body">
      Saída registrada com sucesso!
    </div>
    <button type="button" class="btn-close btn-close-white me-2 m-auto" onclick="hideToast('toast-success')"></button>
  </div>
</div>

<div id="toast-error" class="toast align-items-center text-bg-danger border-0" role="alert" aria-live="assertive" aria-atomic="true" style="display:none;">
  <div class="d-flex">
    <div class="toast-body">
      Ocorreu um erro ao registrar a saída.
    </div>
    <button type="button" class="btn-close btn-close-white me-2 m-auto" onclick="hideToast('toast-error')"></button>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?= base_url('assets/layout.js'); ?>"></script>
<script>
  function showToast(id) {
    const toast = document.getElementById(id);
    toast.style.display = 'block';
    setTimeout(() => { toast.style.display = 'none'; }, 3000);
  }
  function hideToast(id) {
    const toast = document.getElementById(id);
    toast.style.display = 'none';
  }

  document.getElementById('saidaForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const formData = new FormData(this);
    fetch('<?= site_url('saidas/salvar'); ?>', {
      method: 'POST',
      body: formData
    })
    .then(response => response.json())
    .then(data => {
      if (data.status === 'success') {
        showToast('toast-success');
        setTimeout(() => { window.location.href = '<?= site_url('saidas'); ?>'; }, 3000);
      } else {
        showToast('toast-error');
      }
    })
    .catch(() => showToast('toast-error'));
  });
</script>
</body>
</html>

