<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Relatórios de Vendas | SIGE</title>
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
        <h3>Relatórios de Vendas</h3>
        <a href="index.html" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Voltar</a>
      </div>

      <div class="mb-3">
        <label for="filtroVendas" class="form-label">Filtrar por:</label>
        <select id="filtroVendas" class="form-select w-auto">
          <option value="tudo" selected>Tudo</option>
          <option value="dia">Dia</option>
          <option value="semana">Semana</option>
          <option value="mes">Mês</option>
          <option value="ano">Ano</option>
        </select>
      </div>

      <div class="table-responsive">
        <table class="table table-striped table-hover align-middle" id="tabelaVendas">
          <thead class="table-light">
            <tr>
              <th>Produto</th>
              <th>Cliente</th>
              <th>Vendedor</th>
              <th>Data</th>
              <th>Valor (Kz)</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>Produto A</td>
              <td>João Silva</td>
              <td>Maria</td>
              <td>01/08/2025</td>
              <td>12000</td>
            </tr>
            <tr>
              <td>Produto B</td>
              <td>Pedro Cardoso</td>
              <td>José</td>
              <td>02/08/2025</td>
              <td>8000</td>
            </tr>
            <tr>
              <td>Serviço C</td>
              <td>Maria Fernandes</td>
              <td>Luisa</td>
              <td>03/08/2025</td>
              <td>5000</td>
            </tr>
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
  <script>
    $(document).ready(function () {
      const filtro = $('#filtroVendas');

      $.fn.dataTable.ext.search.push(function (settings, data) {
        if (settings.nTable.id !== 'tabelaVendas') {
          return true;
        }

        const periodo = filtro.val();
        if (periodo === 'tudo') {
          return true;
        }

        const dataStr = data[3];
        const [d, m, a] = dataStr.split('/').map(Number);
        const dataVenda = new Date(a, m - 1, d);

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

        return dataVenda >= inicio && dataVenda < fim;
      });

      const tabela = $('#tabelaVendas').DataTable({
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
