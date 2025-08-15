<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Relatórios de Estoque | SIGE</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap5.min.css">
  <link href="../../style.css" rel="stylesheet">
</head>
<body class="d-flex min-vh-100 bg-light text-dark">
<?php include __DIR__.'/navbar.php'; ?>
<?php include __DIR__.'/sidebar.php'; ?>
<div class="content">
<div class="container mt-5">
      <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>Relatórios de Estoque</h3>
        <a href="index.html" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Voltar</a>
      </div>

      <div class="mb-3">
        <label for="filtroEstoque" class="form-label">Filtrar por:</label>
        <select id="filtroEstoque" class="form-select w-auto">
          <option value="tudo" selected>Tudo</option>
          <option value="dia">Dia</option>
          <option value="semana">Semana</option>
          <option value="mes">Mês</option>
          <option value="ano">Ano</option>
        </select>
      </div>

      <div class="table-responsive">
        <table class="table table-striped table-hover align-middle" id="tabelaEstoque">
          <thead class="table-light">
            <tr>
              <th>Produto</th>
              <th>Estoque Inicial</th>
              <th>Estoque Atual</th>
              <th>Saídas</th>
              <th>Histórico</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>Produto X</td>
              <td>100</td>
              <td>80</td>
              <td>20</td>
              <td data-search="Entrada: 01/08/2025; Saída: 05/08/2025">
                <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#historicoProdutoX">Ver Histórico</button>
              </td>
            </tr>
            <tr>
              <td>Produto Y</td>
              <td>60</td>
              <td>45</td>
              <td>15</td>
              <td data-search="Entrada: 02/08/2025; Saída: 10/08/2025">
                <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#historicoProdutoY">Ver Histórico</button>
              </td>
            </tr>
            <tr>
              <td>Produto Z</td>
              <td>30</td>
              <td>50</td>
              <td>0</td>
              <td data-search="Entrada: 03/08/2025; Entrada: 15/08/2025">
                <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#historicoProdutoZ">Ver Histórico</button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <!-- Modals de Histórico -->
  <div class="modal fade" id="historicoProdutoX" tabindex="-1" aria-labelledby="historicoProdutoXLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="historicoProdutoXLabel">Histórico - Produto X</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
        </div>
        <div class="modal-body">
          <ul class="mb-0">
            <li>Entrada: 01/08/2025</li>
            <li>Saída: 05/08/2025</li>
          </ul>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="historicoProdutoY" tabindex="-1" aria-labelledby="historicoProdutoYLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="historicoProdutoYLabel">Histórico - Produto Y</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
        </div>
        <div class="modal-body">
          <ul class="mb-0">
            <li>Entrada: 02/08/2025</li>
            <li>Saída: 10/08/2025</li>
          </ul>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="historicoProdutoZ" tabindex="-1" aria-labelledby="historicoProdutoZLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="historicoProdutoZLabel">Histórico - Produto Z</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
        </div>
        <div class="modal-body">
          <ul class="mb-0">
            <li>Entrada: 03/08/2025</li>
            <li>Entrada: 15/08/2025</li>
          </ul>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
        </div>
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
  <script>
    $(document).ready(function () {
      const filtro = $('#filtroEstoque');

      $.fn.dataTable.ext.search.push(function (settings, data) {
        if (settings.nTable.id !== 'tabelaEstoque') {
          return true;
        }

        const periodo = filtro.val();
        if (periodo === 'tudo') {
          return true;
        }

        const datas = (data[4].match(/\d{2}\/\d{2}\/\d{4}/g) || [])
          .map(str => {
            const [d, m, a] = str.split('/').map(Number);
            return new Date(a, m - 1, d);
          });

        const hoje = new Date();
        let inicio, fim;

        switch (periodo) {
          case 'dia':
            inicio = new Date(hoje.getFullYear(), hoje.getMonth(), hoje.getDate());
            fim = new Date(inicio.getFullYear(), inicio.getMonth(), inicio.getDate() + 1);
            break;
          case 'semana':
            const diaSemana = hoje.getDay();
            inicio = new Date(hoje.getFullYear(), hoje.getMonth(), hoje.getDate() - diaSemana);
            fim = new Date(inicio.getFullYear(), inicio.getMonth(), inicio.getDate() + 7);
            break;
          case 'mes':
            inicio = new Date(hoje.getFullYear(), hoje.getMonth(), 1);
            fim = new Date(hoje.getFullYear(), hoje.getMonth() + 1, 1);
            break;
          case 'ano':
            inicio = new Date(hoje.getFullYear(), 0, 1);
            fim = new Date(hoje.getFullYear() + 1, 0, 1);
            break;
          default:
            return true;
        }

        return datas.some(d => d >= inicio && d < fim);
      });

      const tabela = $('#tabelaEstoque').DataTable({
        dom: "<'d-flex justify-content-between align-items-center flex-wrap mb-3'<'d-flex align-items-center gap-2'lf>B>rtip",
        buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
        language: {
          url: 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/pt-PT.json'
        }
      });

      filtro.on('change', function () {
        tabela.draw();
      });
    });
  </script>
  <script src="../../layout.js"></script>
</body>
</html>
