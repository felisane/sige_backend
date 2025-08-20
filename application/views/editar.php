<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Editar Cliente | SIGE</title>
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
      <h4 class="mb-4">Editar Cliente</h4>
      <div class="card shadow-sm">
        <div class="card-body">
          <form id="clienteForm">
            <div class="mb-3">
              <label for="nome" class="form-label">Nome completo</label>
              <input type="text" class="form-control" id="nome" name="nome" value="<?= $dataVar['cliente']['nome']; ?>" required autocomplete="off">
            </div>
            <div class="mb-3">
              <label for="telefone" class="form-label">Número de Telefone</label>
              <input type="text" class="form-control" id="telefone" name="telefone" value="<?= $dataVar['cliente']['telefone']; ?>" required autocomplete="off">
            </div>
            <div class="mb-3">
              <label for="endereco" class="form-label">Endereço</label>
              <input type="text" class="form-control" id="endereco" name="endereco" value="<?= $dataVar['cliente']['endereco']; ?>" required autocomplete="off">
            </div>
            <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Atualizar Cliente</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Toasts -->
  <div id="toast-success" class="toast align-items-center text-bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true" style="display:none;">
    <div class="d-flex">
      <div class="toast-body">
        Cliente atualizado com sucesso!
      </div>
      <button type="button" class="btn-close btn-close-white me-2 m-auto" onclick="hideToast('toast-success')"></button>
    </div>
  </div>
  <div id="toast-error" class="toast align-items-center text-bg-danger border-0" role="alert" aria-live="assertive" aria-atomic="true" style="display:none;">
    <div class="d-flex">
      <div class="toast-body">
        Ocorreu um erro ao atualizar o cliente.
      </div>
      <button type="button" class="btn-close btn-close-white me-2 m-auto" onclick="hideToast('toast-error')"></button>
    </div>
  </div>

  <!-- Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="<?= base_url('assets/layout.js'); ?>"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const form = document.getElementById('clienteForm');
      form.addEventListener('submit', function(event) {
        event.preventDefault();
        const formData = new FormData(form);
        fetch('<?= site_url('clientes/atualizar/' . $dataVar['cliente']['id']); ?>', {
          method: 'POST',
          body: formData
        })
        .then(response => {
          if (!response.ok) throw new Error();
          return response.json();
        })
        .then(() => {
          showToast('toast-success');
        })
        .catch(() => {
          showToast('toast-error');
        });
      });
    });

    function showToast(id) {
      const toast = document.getElementById(id);
      toast.style.display = 'block';
      setTimeout(() => { toast.style.display = 'none'; }, 3000);
    }
    function hideToast(id) {
      document.getElementById(id).style.display = 'none';
    }
  </script>
</body>
</html>

