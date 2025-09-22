<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Saídas | SIGE</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap5.min.css">
  <link href="<?= base_url('assets/style.css'); ?>" rel="stylesheet">
</head>
<body class="d-flex min-vh-100 bg-light text-dark">
<?php $this->load->view('navbar'); ?>
<?php $this->load->view('sidebar'); ?>
<div class="content">
  <div class="container mt-5">
    <h3>Saídas</h3>
    <?php if (!empty($is_admin)): ?>
      <div class="alert alert-info">Saídas com status <strong>pendente</strong> aguardam sua confirmação.</div>
    <?php else: ?>
      <div class="alert alert-warning">As saídas pendentes aguardam confirmação do administrador.</div>
    <?php endif; ?>
    <div id="alertPlaceholder"></div>
    <div class="table-responsive">
      <table class="table table-bordered table-striped datatable">
        <thead>
          <tr>
            <th>Data</th>
            <th>Descrição</th>
            <th>Forma de Pagamento</th>
            <th>Valor (Kz)</th>
            <th>Status</th>
            <th class="text-center">Ações</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($saidas as $s): ?>
          <tr>
            <td><?= date('d/m/Y', strtotime($s->data)); ?></td>
            <td><?= htmlspecialchars($s->descricao, ENT_QUOTES, 'UTF-8'); ?></td>
            <td><?= htmlspecialchars($s->forma_pagamento, ENT_QUOTES, 'UTF-8'); ?></td>
            <td><?= number_format($s->valor, 2, ',', '.'); ?></td>
            <td>
              <?php if ($s->status === 'pendente'): ?>
                <span class="badge bg-warning text-dark">Pendente</span>
              <?php else: ?>
                <span class="badge bg-success">Confirmada</span>
                <?php if (!empty($s->confirmado_por)): ?>
                  <div class="small text-muted mt-1">
                    <?= htmlspecialchars($s->confirmado_por, ENT_QUOTES, 'UTF-8'); ?><br>
                    <?= $s->confirmado_em ? date('d/m/Y H:i', strtotime($s->confirmado_em)) : ''; ?>
                  </div>
                <?php endif; ?>
              <?php endif; ?>
            </td>
            <td class="text-center">
              <?php if (!empty($is_admin) && $s->status === 'pendente'): ?>
                <button type="button" class="btn btn-sm btn-success btn-confirmar" data-url="<?= site_url('saidas/confirmar/' . $s->id); ?>">
                  <i class="bi bi-check2"></i> Confirmar
                </button>
              <?php else: ?>
                <span class="text-muted">—</span>
              <?php endif; ?>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="<?= base_url('assets/tables.js'); ?>"></script>
<script src="<?= base_url('assets/layout.js'); ?>"></script>
<script>
  (function() {
    const alertPlaceholder = document.getElementById('alertPlaceholder');

    function showAlert(type, message) {
      const alertType = type === 'success' ? 'success' : (type === 'info' ? 'info' : 'danger');
      alertPlaceholder.innerHTML = `
        <div class="alert alert-${alertType} alert-dismissible fade show" role="alert">
          ${message}
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>`;
    }

    document.querySelectorAll('.btn-confirmar').forEach(button => {
      button.addEventListener('click', function () {
        const url = this.getAttribute('data-url');
        if (!url) {
          return;
        }

        if (!confirm('Deseja confirmar esta saída?')) {
          return;
        }

        const btn = this;
        btn.disabled = true;

        fetch(url, {
          method: 'POST',
          headers: {
            'X-Requested-With': 'XMLHttpRequest'
          }
        })
        .then(response => response.json().catch(() => ({ status: 'error', message: 'Resposta inválida do servidor.' })))
        .then(data => {
          showAlert(data.status, data.message || '');
          if (data.status === 'success') {
            setTimeout(() => window.location.reload(), 1200);
          } else {
            btn.disabled = false;
          }
        })
        .catch(() => {
          showAlert('error', 'Não foi possível confirmar a saída.');
          btn.disabled = false;
        });
      });
    });
  })();
</script>
</body>
</html>
