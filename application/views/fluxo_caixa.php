<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Fluxo de Caixa | SIGE</title>
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
        <h3>Fluxo de Caixa</h3>
        <a href="index.html" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Voltar</a>
      </div>

      <div class="card mb-4">
        <div class="card-body">
          <h5 class="card-title">Saldo Atual</h5>
          <p>Entradas: <span id="totalEntradas">Kz 0</span></p>
          <p>Saídas: <span id="totalSaidas">Kz 0</span></p>
          <p class="fw-bold">Saldo Atual: <span id="saldoAtual">Kz 0</span></p>
        </div>
      </div>

      <div class="mb-3">
        <div class="d-flex align-items-center w-50">
          <select id="filtroPeriodo" class="form-select me-2">
            <option value="all">Todos</option>
            <option value="day">Dia</option>
            <option value="week">Semana</option>
            <option value="month">Mês</option>
          </select>
          <span id="subFiltro" class="d-none me-2"></span>
          <div class="dropdown">
            <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="searchDropdown" data-bs-toggle="dropdown" aria-expanded="false">
              Pesquisar
            </button>
            <div class="dropdown-menu p-3" aria-labelledby="searchDropdown">
              <input type="search" id="tabelaFluxoSearch" class="form-control" placeholder="Pesquisar">
            </div>
          </div>
        </div>
      </div>

      <div class="card mb-4">
        <div class="card-body">
          <h5 class="card-title">Comparativo de Períodos</h5>
          <div class="mb-3">
            <label for="tipoComparativo" class="form-label">Comparar:</label>
            <select id="tipoComparativo" class="form-select d-inline w-auto">
              <option value="day">Dia</option>
              <option value="week">Semana</option>
              <option value="month">Mês</option>
            </select>
            <span id="comparativoInputs"></span>
          </div>
          <p id="resultadoComparativo" class="fw-bold"></p>
          <canvas id="fluxoChart" height="100"></canvas>
        </div>
      </div>

      <div class="table-responsive">
        <table class="table table-striped table-hover align-middle" id="tabelaFluxo">
          <thead class="table-light">
            <tr>
              <th>Data</th>
              <th>Descrição</th>
              <th>Tipo</th>
              <th>Valor (Kz)</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>01/08/2025</td>
              <td>Venda de Produto X</td>
              <td><span class="badge bg-success">Entrada</span></td>
              <td>15000</td>
            </tr>
            <tr>
              <td>02/08/2025</td>
              <td>Pagamento de Fornecedor Y</td>
              <td><span class="badge bg-danger">Saída</span></td>
              <td>5000</td>
            </tr>
            <tr>
              <td>03/08/2025</td>
              <td>Venda de Serviço Z</td>
              <td><span class="badge bg-success">Entrada</span></td>
              <td>8000</td>
            </tr>
            <tr>
              <td>04/08/2025</td>
              <td>Nova Venda de Produto A</td>
              <td><span class="badge bg-success">Entrada</span></td>
              <td>12000</td>
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
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script>
    $(document).ready(function () {
      const tabela = $('#tabelaFluxo').DataTable({
        dom: 'Brtip',
        buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
        language: {
          url: 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/pt-PT.json'
        }
      });
        $('#tabelaFluxoSearch').on('keyup', function () {
          tabela.search(this.value).draw();
        });


      function adicionarDadosFicticios() {
        const ano = 2025;
        for (let mes = 0; mes < 12; mes++) {
          const entradasMes = mes === 0 ? 9 : 8;
          for (let i = 0; i < entradasMes; i++) {
            const dia = (i % 28) + 1;
            const data = `${String(dia).padStart(2, '0')}/${String(mes + 1).padStart(2, '0')}/${ano}`;
            const entrada = Math.random() < 0.5;
            const descricao = entrada ? `Venda ${mes + 1}-${i + 1}` : `Despesa ${mes + 1}-${i + 1}`;
            const valor = Math.floor(Math.random() * 19000) + 1000;
            const tipoHtml = `<span class="badge ${entrada ? 'bg-success' : 'bg-danger'}">${entrada ? 'Entrada' : 'Saída'}</span>`;
            tabela.row.add([data, descricao, tipoHtml, valor]);
          }
        }
        tabela.draw();
      }

      adicionarDadosFicticios();
      function calcularTotais() {
        let entradas = 0, saidas = 0;
        tabela.rows({ filter: 'applied' }).every(function () {
          const data = this.data();
          const tipo = $('<div>').html(data[2]).text().trim();
          const valor = parseFloat(data[3]);
          if (tipo === 'Entrada') entradas += valor;
          else if (tipo === 'Saída') saidas += valor;
        });
        $('#totalEntradas').text(`Kz ${entradas.toLocaleString()}`);
        $('#totalSaidas').text(`Kz ${saidas.toLocaleString()}`);
        $('#saldoAtual').text(`Kz ${(entradas - saidas).toLocaleString()}`);
      }

      function weekToDate(year, week) {
        const simple = new Date(year, 0, 1 + (week - 1) * 7);
        const dow = simple.getDay();
        const ISOweekStart = new Date(simple);
        if (dow <= 4) ISOweekStart.setDate(simple.getDate() - dow + 1);
        else ISOweekStart.setDate(simple.getDate() + 8 - dow);
        return ISOweekStart;
      }

      function aplicarFiltro(periodo, valor) {
        $.fn.dataTable.ext.search = $.fn.dataTable.ext.search.filter(f => !f._periodoFilter);
        if (periodo === 'all' || !valor) { tabela.draw(); calcularTotais(); return; }
        const filterFunc = function (settings, data) {
          const [d, m, y] = data[0].split('/').map(Number);
          const rowDate = new Date(y, m - 1, d);
          if (periodo === 'day') {
            const sel = new Date(valor);
            return rowDate.toDateString() === sel.toDateString();
          } else if (periodo === 'week') {
            const [year, wk] = valor.split('-W').map(Number);
            const start = weekToDate(year, wk);
            const end = new Date(start);
            end.setDate(start.getDate() + 6);
            return rowDate >= start && rowDate <= end;
          } else if (periodo === 'month') {
            const [year, month] = valor.split('-').map(Number);
            return rowDate.getFullYear() === year && (rowDate.getMonth() + 1) === month;
          }
          return true;
        };
        filterFunc._periodoFilter = true;
        $.fn.dataTable.ext.search.push(filterFunc);
        tabela.draw();
        calcularTotais();
      }

      $('#filtroPeriodo').on('change', function () {
        mostrarSubFiltro(this.value);
        const val = $('#subFiltro input').val();
        aplicarFiltro(this.value, val);
      });

      $('#subFiltro').on('change', 'input', function () {
        const periodo = $('#filtroPeriodo').val();
        aplicarFiltro(periodo, this.value);
      });

      function mostrarSubFiltro(periodo) {
        let html = '';
        if (periodo === 'day') html = '<input type="date" class="form-control w-auto" />';
        else if (periodo === 'week') html = '<input type="week" class="form-control w-auto" />';
        else if (periodo === 'month') html = '<input type="month" class="form-control w-auto" />';
        $('#subFiltro').html(html);
        $('#subFiltro').toggleClass('d-none', periodo === 'all');
      }

      const ctx = document.getElementById('fluxoChart').getContext('2d');
      let comparativoChart;

      function mostrarInputsComparativo(tipo) {
        let html = '';
        if (tipo === 'day') html = '<input type="date" id="compInput1" class="form-control d-inline w-auto me-2" /> <input type="date" id="compInput2" class="form-control d-inline w-auto" />';
        else if (tipo === 'week') html = '<input type="week" id="compInput1" class="form-control d-inline w-auto me-2" /> <input type="week" id="compInput2" class="form-control d-inline w-auto" />';
        else if (tipo === 'month') html = '<input type="month" id="compInput1" class="form-control d-inline w-auto me-2" /> <input type="month" id="compInput2" class="form-control d-inline w-auto" />';
        $('#comparativoInputs').html(html);
      }

      function obterSaldoPeriodo(tipo, valor) {
        let start, end;
        if (tipo === 'day') {
          start = end = new Date(valor);
        } else if (tipo === 'week') {
          const [year, wk] = valor.split('-W').map(Number);
          start = weekToDate(year, wk);
          end = new Date(start);
          end.setDate(start.getDate() + 6);
        } else if (tipo === 'month') {
          const [year, month] = valor.split('-').map(Number);
          start = new Date(year, month - 1, 1);
          end = new Date(year, month, 0);
        }
        let entradas = 0, saidas = 0;
        tabela.rows().every(function () {
          const data = this.data();
          const tipo = $('<div>').html(data[2]).text().trim();
          const valor = parseFloat(data[3]);
          const [d, m, y] = data[0].split('/').map(Number);
          const rowDate = new Date(y, m - 1, d);
          if (rowDate >= start && rowDate <= end) {
            if (tipo === 'Entrada') entradas += valor;
            else if (tipo === 'Saída') saidas += valor;
          }
        });
        return entradas - saidas;
      }

      function formatLabel(tipo, valor) {
        if (tipo === 'day') return new Date(valor).toLocaleDateString('pt-PT');
        if (tipo === 'week') {
          const [year, wk] = valor.split('-W');
          return `Sem ${wk}/${year}`;
        }
        if (tipo === 'month') {
          const [year, month] = valor.split('-');
          return `${month}/${year}`;
        }
      }

      function atualizarGraficoComparativo() {
        const tipo = $('#tipoComparativo').val();
        const v1 = $('#compInput1').val();
        const v2 = $('#compInput2').val();
        if (!v1 || !v2) return;
        const total1 = obterSaldoPeriodo(tipo, v1);
        const total2 = obterSaldoPeriodo(tipo, v2);
        const perc = total1 !== 0 ? ((total2 - total1) / total1) * 100 : 0;
        $('#resultadoComparativo').text(`Desempenho: ${perc.toFixed(2)}%`);
        const dataChart = {
          labels: [formatLabel(tipo, v1), formatLabel(tipo, v2)],
          datasets: [{ label: 'Saldo Líquido', data: [total1, total2], backgroundColor: ['rgba(75, 192, 192, 0.5)', 'rgba(255, 99, 132, 0.5)'] }]
        };
        if (comparativoChart) comparativoChart.destroy();
        comparativoChart = new Chart(ctx, { type: 'bar', data: dataChart, options: { responsive: true } });
      }

      $('#tipoComparativo').on('change', function () {
        mostrarInputsComparativo(this.value);
      });

      $('#comparativoInputs').on('change', 'input', atualizarGraficoComparativo);

      tabela.on('draw', function () {
        calcularTotais();
      });

      mostrarInputsComparativo('day');
      calcularTotais();
    });
  </script>
  <script src="../../layout.js"></script>
</body>
</html>
