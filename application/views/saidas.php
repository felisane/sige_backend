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
<div class="container-fluid">
      <h4 class="mb-4">Registrar Saída</h4>
      <div class="card shadow-sm mb-4">
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
              <input type="number" class="form-control" id="valorSaida" name="valor" required>
            </div>
            <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Registrar Saída</button>
          </form>
        </div>
      </div>

      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Saídas Registradas</h5>
          <div class="table-responsive">
            <table class="table table-striped table-hover" id="tabelaSaidas">
              <thead class="table-light">
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
                  <td data-order="<?= $s->valor; ?>"><?= number_format($s->valor, 2, ',', '.'); ?></td>
                </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div id="toast-success" class="toast align-items-center text-bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true" style="position: fixed; top: 20px; right: 20px; display:none;">
    <div class="d-flex">
      <div class="toast-body">
        Saída registrada com sucesso!
      </div>
      <button type="button" class="btn-close btn-close-white me-2 m-auto" onclick="hideToast('toast-success')"></button>
    </div>
  </div>

  <div id="toast-error" class="toast align-items-center text-bg-danger border-0" role="alert" aria-live="assertive" aria-atomic="true" style="position: fixed; top: 20px; right: 20px; display:none;">
    <div class="d-flex">
      <div class="toast-body">
        Ocorreu um erro ao registrar a saída.
      </div>
      <button type="button" class="btn-close btn-close-white me-2 m-auto" onclick="hideToast('toast-error')"></button>
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
  <script src="<?= base_url('assets/layout.js'); ?>"></script>
  <script>
    $(document).ready(function () {
      const tabela = $('#tabelaSaidas').DataTable({
        dom: 'Brtip',
        buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
        language: {
          url: 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/pt-PT.json'
        }
      });

      const form = document.getElementById('saidaForm');
      form.addEventListener('submit', function (e) {
        e.preventDefault();
        const formData = new FormData(form);
        fetch('<?= site_url('caixa/registrar_saida'); ?>', {
          method: 'POST',
          body: formData
        })
        .then(response => response.json())
        .then(data => {
          if (data.status === 'success') {
            showToast('toast-success');
            const dataFormatada = new Date(formData.get('data')).toLocaleDateString('pt-PT');
            const valor = parseFloat(formData.get('valor'));
            const valorFormatado = valor.toLocaleString('pt-BR', {minimumFractionDigits: 2, maximumFractionDigits: 2});
            tabela.row.add([
              dataFormatada,
              formData.get('descricao'),
              valorFormatado
            ]).draw();
            const node = tabela.row(':last').node();
            $(node).find('td').eq(2).attr('data-order', valor);
            form.reset();
          } else {
            showToast('toast-error');
          }
        })
        .catch(() => showToast('toast-error'));
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
