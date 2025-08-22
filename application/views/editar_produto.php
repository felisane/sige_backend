<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Editar Produto | SIGE</title>
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
<div class="content">
  <div class="container-fluid">
      <h4 class="mb-4">Editar Produto</h4>
      <div class="card shadow-sm">
        <div class="card-body">
          <form id="produtoForm" enctype="multipart/form-data">
            <div class="mb-3">
              <label for="imagem" class="form-label">Imagem do Produto</label>
              <input type="file" class="form-control" id="imagem" name="imagem" accept="image/*">
              <?php if (!empty($produto->imagem)): ?>
                <img src="<?= base_url('uploads/' . $produto->imagem); ?>" alt="<?= $produto->nome; ?>" class="img-thumbnail mt-2" style="width:100px;">
              <?php endif; ?>
            </div>
            <div class="mb-3">
              <label for="nome" class="form-label">Nome do Produto</label>
              <input type="text" class="form-control" id="nome" name="nome" value="<?= $produto->nome; ?>" required autocomplete="off">
            </div>
            <div class="mb-3">
              <label for="categoria" class="form-label">Categoria</label>
              <select class="form-select" id="categoria" name="categoria" required>
                <option value="" disabled>Selecione uma categoria</option>
                <?php foreach ($categorias as $categoria): ?>
                  <option value="<?= $categoria->nome; ?>" <?= $categoria->nome == $produto->categoria ? 'selected' : ''; ?>><?= $categoria->nome; ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="mb-3">
              <label for="preco" class="form-label">Preço</label>
              <input type="number" class="form-control" id="preco" name="preco" value="<?= $produto->preco; ?>" required autocomplete="off">
            </div>
            <div class="mb-3">
              <label for="estoque" class="form-label">Estoque</label>
              <input type="number" class="form-control" id="estoque" name="estoque" value="<?= $produto->estoque; ?>" required autocomplete="off">
            </div>
            <div class="mb-3">
              <label for="descricao" class="form-label">Descrição</label>
              <textarea class="form-control" id="descricao" name="descricao" rows="3"><?= $produto->descricao; ?></textarea>
            </div>
            <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Atualizar Produto</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <div id="alert-error" class="alert alert-danger alert-fixed" role="alert" style="display:none;">
    Ocorreu um erro ao atualizar o produto.
  </div>

  <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="successModalLabel">Sucesso</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          Produto atualizado com sucesso!
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="<?= base_url('assets/layout.js'); ?>"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const form = document.getElementById('produtoForm');
      form.addEventListener('submit', function(event) {
        event.preventDefault();
        const formData = new FormData(form);
        fetch('<?= site_url('produtos/atualizar/' . $produto->id); ?>', {
          method: 'POST',
          body: formData
        })
        .then(response => {
          if (!response.ok) throw new Error();
          return response.json();
        })
        .then(data => {
          if (data.status === 'success') {
            const successModal = new bootstrap.Modal(document.getElementById('successModal'));
            successModal.show();
            setTimeout(() => {
              successModal.hide();
              window.location.href = '<?= site_url('produtos/lista'); ?>';
            }, 2000);
          } else {
            throw new Error();
          }
        })
        .catch(() => {
          const alert = document.getElementById('alert-error');
          alert.style.display = 'block';
          setTimeout(() => {
            alert.style.display = 'none';
          }, 3000);
        });
      });
    });
  </script>
</body>
</html>

