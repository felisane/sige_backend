<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Adicionar Produtos | SIGE</title>
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
      <h4 class="mb-4">Adicionar Novo Produto</h4>
      <div class="card shadow-sm">
        <div class="card-body">
          <form id="produtoForm">
            <div class="mb-3">
              <label for="imagem" class="form-label">Imagem do Produto</label>
              <input type="file" class="form-control" id="imagem" accept="image/*" required>
            </div>
            <div class="mb-3">
              <label for="nome" class="form-label">Nome do Produto</label>
              <input type="text" class="form-control" id="nome" placeholder="Ex: Óleo de Motor" required autocomplete="off">
            </div>
            <div class="mb-3">
              <label for="categoria" class="form-label">Categoria</label>
              <select class="form-select" id="categoria" required>
                <option value="" selected disabled>Selecione uma categoria</option>
                <option value="Lubrificantes">Lubrificantes</option>
                <option value="Filtros">Filtros</option>
                <option value="Freios">Freios</option>
                <option value="Acessórios">Acessórios</option>
              </select>
            </div>
            <div class="mb-3">
              <label for="preco" class="form-label">Preço</label>
              <input type="number" class="form-control" id="preco" placeholder="Ex: 8000" required autocomplete="off">
            </div>
            <div class="mb-3">
              <label for="estoque" class="form-label">Estoque</label>
              <input type="number" class="form-control" id="estoque" placeholder="Ex: 20" required autocomplete="off">
            </div>
            <div class="mb-3">
              <label for="descricao" class="form-label">Descrição</label>
              <textarea class="form-control" id="descricao" rows="3" placeholder="Detalhes do produto"></textarea>
            </div>
            <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Salvar Produto</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Toast Feedback -->
  <div id="toast-success" class="toast align-items-center text-bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true" style="display:none;">
    <div class="d-flex">
      <div class="toast-body">
        Produto cadastrado com sucesso!
      </div>
      <button type="button" class="btn-close btn-close-white me-2 m-auto" onclick="hideToast('toast-success')"></button>
    </div>
  </div>

  <div id="toast-error" class="toast align-items-center text-bg-danger border-0" role="alert" aria-live="assertive" aria-atomic="true" style="display:none;">
    <div class="d-flex">
      <div class="toast-body">
        Ocorreu um erro ao cadastrar o produto.
      </div>
      <button type="button" class="btn-close btn-close-white me-2 m-auto" onclick="hideToast('toast-error')"></button>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="<?= base_url('assets/layout.js'); ?>"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const form = document.getElementById('produtoForm');
      form.onsubmit = function(event) {
        event.preventDefault();
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

