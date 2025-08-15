<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Cadastrar Cliente | SIGE</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link href="../../style.css" rel="stylesheet">
  <style>
    .toast { position: fixed; top: 20px; right: 20px; z-index: 9999; }
  </style>
</head>
<body class="d-flex min-vh-100 bg-light text-dark">
<?php include __DIR__.'/navbar.php'; ?>
<?php include __DIR__.'/sidebar.php'; ?>

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
              <input type="text" class="form-control" id="nome" placeholder="Ex: João da Silva" required autocomplete="off">
            </div>
            <!-- Campo para o endereço do cliente -->
            <div class="mb-3">
              <label for="endereco" class="form-label">Endereço</label>
              <input type="text" class="form-control" id="endereco" name="endereco" placeholder="Rua, Bairro, Cidade" required autocomplete="off">
            </div>
            <!-- Campo para o telefone do cliente -->
            <div class="mb-3">
              <label for="telefone" class="form-label">Telefone</label>
              <input type="tel" class="form-control" id="telefone" placeholder="Ex: 923 000 000" required autocomplete="off">
            </div>
            <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Salvar Cliente</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Toast Feedback -->
  <!-- Toast de sucesso -->
  <div id="toast-success" class="toast align-items-center text-bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true" style="display:none;">
    <!-- Estrutura flexível do toast de sucesso -->
    <div class="d-flex">
      <!-- Mensagem de sucesso -->
      <div class="toast-body">
        Cliente cadastrado com sucesso!
      </div>
      <button type="button" class="btn-close btn-close-white me-2 m-auto" onclick="hideToast('toast-success')"></button>
    </div>
  </div>
  <!-- Toast de erro -->
  <div id="toast-error" class="toast align-items-center text-bg-danger border-0" role="alert" aria-live="assertive" aria-atomic="true" style="display:none;">
    <!-- Estrutura flexível do toast de erro -->
    <div class="d-flex">
      <!-- Mensagem de erro -->
      <div class="toast-body">
        Ocorreu um erro ao cadastrar o cliente.
      </div>
      <button type="button" class="btn-close btn-close-white me-2 m-auto" onclick="hideToast('toast-error')"></button>
    </div>
  </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../../layout.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
      const form = document.getElementById('clienteForm');
      form.onsubmit = function(event) {
        event.preventDefault();
        // Simulate success (replace with real logic)
        showToast('toast-success');
        form.reset();
      };
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
