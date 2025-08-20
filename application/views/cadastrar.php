<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Cadastrar Cliente | SIGE</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link href="<?= base_url('assets/style.css'); ?>" rel="stylesheet">
  <style>
    .alert-fixed { position: fixed; top: 20px; right: 20px; z-index: 9999; }
  </style>
</head>
<body class="d-flex min-vh-100 bg-light text-dark">
<?php $this->load->view('navbar'); ?>
<?php $this->load->view('sidebar'); ?>

  <!-- Contêiner onde a barra lateral é carregada -->
<!-- Área principal do conteúdo -->
  <div class="content">
    <!-- Contêiner para a navbar -->
<!-- Área fluida para o formulário -->
    <div class="container-fluid">
      <h4 class="mb-4">Cadastrar Novo Cliente</h4>
      <!-- Cartão que contém o formulário de cadastro -->
      <div class="card shadow-sm">
        <!-- Corpo do cartão com campos do formulário -->
        <div class="card-body">
          <form id="clienteForm">
            <!-- Campo para o nome do cliente -->
            <div class="mb-3">
              <label for="nome" class="form-label">Nome completo</label>
              <input type="text" class="form-control" id="nome" name="nome" placeholder="Ex: João da Silva" required autocomplete="off">
            </div>
            <!-- Campo para o telefone do cliente -->
            <div class="mb-3">
              <label for="telefone" class="form-label">Número de Telefone</label>
              <input type="text" class="form-control" id="telefone" name="telefone" placeholder="Ex: 999999999" required autocomplete="off">
            </div>
            <!-- Campo para o endereço do cliente -->
            <div class="mb-3">
              <label for="endereco" class="form-label">Endereço</label>
              <input type="text" class="form-control" id="endereco" name="endereco" placeholder="Ex: Rua A, 123" required autocomplete="off">
            </div>
            <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Salvar Cliente</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Alertas -->
  <div id="alert-error" class="alert alert-danger alert-fixed" role="alert" style="display:none;">
    Ocorreu um erro ao cadastrar o cliente.
  </div>

  <!-- Modal de Sucesso -->
  <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="successModalLabel">Sucesso</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          Cliente cadastrado com sucesso!
        </div>
      </div>
    </div>
  </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url('assets/layout.js'); ?>"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
      const form = document.getElementById('clienteForm');
      form.addEventListener('submit', function(event) {
        event.preventDefault();
        const formData = new FormData(form);
        fetch('<?= site_url('clientes/salvar'); ?>', {
          method: 'POST',
          body: formData
        })
        .then(response => {
          if (!response.ok) throw new Error();
          return response.json();
        })
        .then(() => {
          const successModal = new bootstrap.Modal(document.getElementById('successModal'));
          successModal.show();
          setTimeout(() => {
            successModal.hide();
            window.location.href = '<?= site_url('clientes/lista'); ?>';
          }, 2000);
        })
        .catch(() => {
          const alertError = document.getElementById('alert-error');
          alertError.style.display = 'block';
          setTimeout(() => {
            alertError.style.display = 'none';
          }, 3000);
        });
      });
    });
  </script>
</body>
</html>
