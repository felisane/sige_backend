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
    .alert-fixed { position: fixed; top: 20px; right: 20px; z-index: 9999; }
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

  <!-- Alertas -->
  <div id="alert-error" class="alert alert-danger alert-fixed" role="alert" style="display:none;">
    Ocorreu um erro ao atualizar o cliente.
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
          Cliente atualizado com sucesso!
        </div>
      </div>
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
          const successModal = new bootstrap.Modal(document.getElementById('successModal'));
          successModal.show();
          setTimeout(() => {
            successModal.hide();
            window.location.href = '<?= site_url('clientes/lista'); ?>';
          }, 2000);
        })
        .catch(() => {
          document.getElementById('alert-error').style.display = 'block';
          setTimeout(() => {
            document.getElementById('alert-error').style.display = 'none';
          }, 3000);
        });
      });
    });
  </script>
</body>
</html>

