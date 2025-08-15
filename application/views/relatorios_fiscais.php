<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Relatórios Fiscais | SIGE</title>
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
        <h3>Relatórios Fiscais</h3>
        <a href="index.html" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Voltar</a>
      </div>

      <div class="mb-3">
        <label for="filtroFiscais" class="form-label">Filtrar por:</label>
        <select id="filtroFiscais" class="form-select w-auto">
          <option value="tudo" selected>Tudo</option>
          <option value="dia">Dia</option>
          <option value="semana">Semana</option>
          <option value="mes">Mês</option>
          <option value="ano">Ano</option>
        </select>
      </div>

      <div class="table-responsive">
        <table class="table table-striped table-hover align-middle" id="tabelaFiscais">
          <thead class="table-light">
            <tr>
              <th>Mês</th>
              <th>Vendas Brutas (Kz)</th>
              <th>IVA (14%)</th>
              <th>Situação</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>Julho/2025</td>
              <td>150000</td>
              <td>21000</td>
              <td><span class="badge bg-success">Entregue</span></td>
            </tr>
            <tr>
              <td>Agosto/2025</td>
              <td>180000</td>
              <td>25200</td>
              <td><span class="badge bg-warning text-dark">Pendente</span></td>
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
      const filtro = $('#filtroFiscais');
      const meses = {
        'Janeiro': 0,
        'Fevereiro': 1,
        'Março': 2,
        'Abril': 3,
        'Maio': 4,
        'Junho': 5,
        'Julho': 6,
        'Agosto': 7,
        'Setembro': 8,
        'Outubro': 9,
        'Novembro': 10,
        'Dezembro': 11
      };

      $.fn.dataTable.ext.search.push(function (settings, data) {
        if (settings.nTable.id !== 'tabelaFiscais') {
          return true;
        }

        const periodo = filtro.val();
        if (periodo === 'tudo') {
          return true;
        }

        const [mesNome, anoStr] = data[0].split('/');
        const month = meses[mesNome];
        const year = parseInt(anoStr, 10);
        const inicioPeriodo = new Date(year, month, 1);
        const fimPeriodo = new Date(year, month + 1, 1);

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

        return inicioPeriodo < fim && fimPeriodo >= inicio;
      });

      const tabela = $('#tabelaFiscais').DataTable({
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
