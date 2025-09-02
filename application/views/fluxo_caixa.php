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
  <link href="<?= base_url('assets/style.css'); ?>" rel="stylesheet">
</head>
<body class="d-flex min-vh-100 bg-light text-dark">
<?php $this->load->view('navbar'); ?>
<?php $this->load->view('sidebar'); ?>
<div class="content">
<div class="container mt-5">
      <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>Fluxo de Caixa</h3>
        <a href="<?= site_url('home'); ?>" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Voltar</a>
      </div>

      <div class="card mb-4">
        <div class="card-body">
          <h5 class="card-title">Saldo Atual</h5>
          <p>Entradas: <span id="totalEntradas">Kz 0,00</span></p>
          <p>Saídas: <span id="totalSaidas">Kz 0,00</span></p>
          <p class="fw-bold">Saldo Atual: <span id="saldoAtual">Kz 0,00</span></p>
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

      <!-- Filtro Comparativo removido -->

      <div class="card mb-4">
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover align-middle datatable" id="tabelaFluxo">
              <thead class="table-light">
                <tr>
                  <th>Data</th>
                  <th>Descrição</th>
                  <th>Quantidade</th>
                  <th>Tipo</th>
                  <th>Forma de Pagamento</th>
                  <th>Valor (Kz)</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($vendas as $venda): ?>
                <tr>
                  <td><?= date('d/m/Y', strtotime($venda->data)); ?></td>
                  <td><?= htmlspecialchars($venda->produto, ENT_QUOTES, 'UTF-8'); ?></td>
                  <td><?= $venda->quantidade; ?></td>
                  <td><span class="badge bg-success">Entrada</span></td>
                  <td><?= htmlspecialchars($venda->forma_pagamento, ENT_QUOTES, 'UTF-8'); ?></td>
                  <td data-order="<?= $venda->valor; ?>"><?= number_format($venda->valor, 2, ',', '.'); ?></td>
                </tr>
                <?php endforeach; ?>
                <?php foreach ($saidas as $saida): ?>
                <tr>
                  <td><?= date('d/m/Y', strtotime($saida->data)); ?></td>
                  <td><?= htmlspecialchars($saida->descricao, ENT_QUOTES, 'UTF-8'); ?></td>
                  <td>-</td>
                  <td><span class="badge bg-danger">Saída</span></td>
                  <td><?= htmlspecialchars($saida->forma_pagamento, ENT_QUOTES, 'UTF-8'); ?></td>
                  <td data-order="<?= $saida->valor; ?>"><?= number_format($saida->valor, 2, ',', '.'); ?></td>
                </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
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
  <script src="<?= base_url('assets/tables.js'); ?>"></script>
  <script>
    $(document).ready(function () {
      const tabela = $('#tabelaFluxo').DataTable();
      $('#tabelaFluxoSearch').on('keyup', function () {
        tabela.search(this.value).draw();
      });


      function calcularTotais() {
        let entradas = 0, saidas = 0;
        tabela.rows({ filter: 'applied' }).every(function () {
          const data = this.data();
          const tipo = $('<div>').html(data[3]).text().trim();
          const valor = parseFloat($(this.node()).find('td').eq(5).data('order'));
          if (tipo === 'Entrada') entradas += valor;
          else if (tipo === 'Saída') saidas += valor;
        });
        $('#totalEntradas').text(`Kz ${entradas.toLocaleString('pt-BR', {minimumFractionDigits: 2, maximumFractionDigits: 2})}`);
        $('#totalSaidas').text(`Kz ${saidas.toLocaleString('pt-BR', {minimumFractionDigits: 2, maximumFractionDigits: 2})}`);
        $('#saldoAtual').text(`Kz ${(entradas - saidas).toLocaleString('pt-BR', {minimumFractionDigits: 2, maximumFractionDigits: 2})}`);
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


      tabela.on('draw', function () {
        calcularTotais();
      });

        calcularTotais();
    });
  </script>
  <script src="<?= base_url('assets/layout.js'); ?>"></script>
</body>
</html>
