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
          <div class="d-flex flex-wrap justify-content-between align-items-start gap-3">
            <div>
              <h5 class="card-title mb-1">Status do Caixa</h5>
              <p class="mb-2 text-muted" id="statusDescricao">Carregando status do caixa...</p>
              <p class="mb-1"><strong>Início do período:</strong> <span id="infoAberturaAtual">-</span></p>
              <p class="mb-0"><strong>Fecho do período:</strong> <span id="infoFechamentoAtual">-</span></p>
            </div>
            <div class="text-end ms-auto">
              <div id="statusMensagem" class="small mb-2 d-none"></div>
              <button type="button" id="btnAbrirCaixa" class="btn btn-success d-none"><i class="bi bi-play-circle"></i> Abrir Caixa</button>
              <button type="button" id="btnFecharCaixa" class="btn btn-danger d-none"><i class="bi bi-stop-circle"></i> Fechar Caixa</button>
            </div>
          </div>
        </div>
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
            <option value="month" selected>Mês</option>
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
          <h5 class="card-title">Registros de Períodos do Caixa</h5>
          <div class="table-responsive">
            <table class="table table-striped align-middle" id="tabelaPeriodos">
              <thead>
                <tr>
                  <th>Abertura</th>
                  <th>Usuário (abertura)</th>
                  <th>Fecho</th>
                  <th>Usuário (fecho)</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td colspan="4" class="text-center text-muted">Carregando registros...</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>

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
                <?php $total = $venda->valor * $venda->quantidade; ?>
                <tr>
                  <td><?= date('d/m/Y', strtotime($venda->data)); ?></td>
                  <td><?= htmlspecialchars($venda->produto, ENT_QUOTES, 'UTF-8'); ?></td>
                  <td><?= $venda->quantidade; ?></td>
                  <td><span class="badge bg-success">Entrada</span></td>
                  <td><?= htmlspecialchars($venda->forma_pagamento, ENT_QUOTES, 'UTF-8'); ?></td>
                  <td data-order="<?= $total; ?>"><?= number_format($total, 2, ',', '.'); ?></td>
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

  <div class="modal fade" id="modalFechoCaixa" tabindex="-1" aria-labelledby="modalFechoCaixaLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalFechoCaixaLabel">Confirmar Fecho do Caixa</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
        </div>
        <div class="modal-body">
          <form id="formFechoCaixa" novalidate>
            <div class="mb-3">
              <label for="fechoDinheiro" class="form-label">Dinheiro (Kz)</label>
              <input type="number" min="0" step="0.01" class="form-control" id="fechoDinheiro" required>
            </div>
            <div class="mb-3">
              <label for="fechoPos" class="form-label">POS (Kz)</label>
              <input type="number" min="0" step="0.01" class="form-control" id="fechoPos" required>
            </div>
            <div class="mb-3">
              <label for="fechoTransferencias" class="form-label">Transferências (Kz)</label>
              <input type="number" min="0" step="0.01" class="form-control" id="fechoTransferencias" required>
            </div>
            <div class="mb-3">
              <label for="fechoObservacoes" class="form-label">Observações</label>
              <textarea class="form-control" id="fechoObservacoes" rows="3" placeholder="Detalhes adicionais (opcional)"></textarea>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="checkbox" value="1" id="confirmarResponsavel" required>
              <label class="form-check-label" for="confirmarResponsavel">
                Confirmo que os valores informados foram verificados pelo responsável.
              </label>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="button" class="btn btn-danger" id="confirmarFechoCaixa">Confirmar Fecho</button>
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
      const statusDescricao = $('#statusDescricao');
      const infoAberturaAtual = $('#infoAberturaAtual');
      const infoFechamentoAtual = $('#infoFechamentoAtual');
      const btnAbrirCaixa = $('#btnAbrirCaixa');
      const btnFecharCaixa = $('#btnFecharCaixa');
      const statusMensagem = $('#statusMensagem');
      const modalFechoCaixaEl = document.getElementById('modalFechoCaixa');
      const modalFechoCaixa = new bootstrap.Modal(modalFechoCaixaEl);
      const formFechoCaixa = $('#formFechoCaixa');
      const inputDinheiro = $('#fechoDinheiro');
      const inputPos = $('#fechoPos');
      const inputTransferencias = $('#fechoTransferencias');
      const inputObservacoes = $('#fechoObservacoes');
      const inputConfirmarResponsavel = $('#confirmarResponsavel');
      const btnConfirmarFechoCaixa = $('#confirmarFechoCaixa');
      const tabelaPeriodosBody = $('#tabelaPeriodos tbody');
      const periodosUrl = '<?= site_url('caixa/periodos'); ?>';
      const abrirUrl = '<?= site_url('caixa/abrir_periodo'); ?>';
      const fecharUrl = '<?= site_url('caixa/fechar_periodo'); ?>';

      $('#tabelaFluxoSearch').on('keyup', function () {
        tabela.search(this.value).draw();
      });

      function mostrarMensagem(texto, sucesso = true) {
        statusMensagem
          .toggleClass('d-none', false)
          .toggleClass('text-success', sucesso)
          .toggleClass('text-danger', !sucesso)
          .text(texto);
      }

      function limparMensagem() {
        statusMensagem.addClass('d-none').removeClass('text-success text-danger').text('');
      }

      function atualizarPeriodos() {
        fetch(periodosUrl)
          .then((resposta) => resposta.json())
          .then((dados) => {
            if (!dados || dados.status !== 'success') {
              throw new Error();
            }

            const periodoAtual = dados.periodo_atual;
            if (periodoAtual) {
              statusDescricao.text(`Caixa aberto desde ${periodoAtual.abertura_formatada} por ${periodoAtual.usuario_abertura}.`);
              infoAberturaAtual.text(periodoAtual.abertura_formatada);
              infoFechamentoAtual.text(periodoAtual.fechamento_formatado ? periodoAtual.fechamento_formatado : 'Em aberto');
              btnAbrirCaixa.addClass('d-none');
              btnFecharCaixa.removeClass('d-none');
            } else {
              statusDescricao.text('Caixa fechado. Clique em "Abrir Caixa" para iniciar um novo período.');
              infoAberturaAtual.text('-');
              infoFechamentoAtual.text('-');
              btnAbrirCaixa.removeClass('d-none');
              btnFecharCaixa.addClass('d-none');
            }

            tabelaPeriodosBody.empty();

            if (!dados.periodos || dados.periodos.length === 0) {
              tabelaPeriodosBody.append('<tr><td colspan="4" class="text-center text-muted">Nenhum período registrado.</td></tr>');
              return;
            }

            dados.periodos.forEach((periodo) => {
              const linha = $('<tr></tr>');
              linha.append($('<td></td>').text(periodo.abertura_formatada));
              linha.append($('<td></td>').text(periodo.usuario_abertura || '-'));
              if (periodo.fechamento_formatado) {
                linha.append($('<td></td>').text(periodo.fechamento_formatado));
              } else {
                linha.append($('<td></td>').html('<span class="badge bg-warning text-dark">Em aberto</span>'));
              }
              linha.append($('<td></td>').text(periodo.usuario_fechamento || '-'));
              tabelaPeriodosBody.append(linha);
            });

            limparMensagem();
          })
          .catch(() => {
            statusDescricao.text('Não foi possível carregar o status do caixa. Tente novamente mais tarde.');
          });
      }

      function executarAcao(url, botao, mensagemSucesso) {
        botao.prop('disabled', true);
        fetch(url, {
          method: 'POST',
          headers: {
            'X-Requested-With': 'XMLHttpRequest',
          },
        })
          .then((resposta) => resposta.json())
          .then((dados) => {
            if (dados.status === 'success') {
              mostrarMensagem(mensagemSucesso, true);
              atualizarPeriodos();
            } else {
              mostrarMensagem(dados.message || 'Ocorreu um erro ao processar a solicitação.', false);
            }
          })
          .catch(() => {
            mostrarMensagem('Não foi possível completar a operação. Verifique a sua conexão e tente novamente.', false);
          })
          .finally(() => {
            botao.prop('disabled', false);
          });
      }

      btnAbrirCaixa.on('click', function () {
        executarAcao(abrirUrl, btnAbrirCaixa, 'Caixa aberto com sucesso.');
      });

      btnFecharCaixa.on('click', function () {
        formFechoCaixa[0].reset();
        inputConfirmarResponsavel.prop('checked', false);
        modalFechoCaixa.show();
      });

      $(modalFechoCaixaEl).on('hidden.bs.modal', function () {
        formFechoCaixa[0].reset();
        inputConfirmarResponsavel.prop('checked', false);
      });

      function obterValorNumerico(campo, descricao) {
        const texto = (campo.val() || '').trim();
        if (texto === '') {
          mostrarMensagem(`Informe o valor para ${descricao}.`, false);
          campo.trigger('focus');
          return null;
        }

        const numero = Number(texto);
        if (!Number.isFinite(numero)) {
          mostrarMensagem(`O valor informado para ${descricao} é inválido.`, false);
          campo.trigger('focus');
          return null;
        }

        if (numero < 0) {
          mostrarMensagem(`O valor de ${descricao} não pode ser negativo.`, false);
          campo.trigger('focus');
          return null;
        }

        return numero;
      }

      btnConfirmarFechoCaixa.on('click', function () {
        const dinheiro = obterValorNumerico(inputDinheiro, 'Dinheiro');
        if (dinheiro === null) { return; }

        const pos = obterValorNumerico(inputPos, 'POS');
        if (pos === null) { return; }

        const transferencias = obterValorNumerico(inputTransferencias, 'Transferências');
        if (transferencias === null) { return; }

        if (!inputConfirmarResponsavel.is(':checked')) {
          mostrarMensagem('Confirme a verificação do responsável para finalizar o fecho.', false);
          inputConfirmarResponsavel.trigger('focus');
          return;
        }

        const payload = {
          dinheiro,
          pos,
          transferencias,
          observacoes: (inputObservacoes.val() || '').trim(),
        };

        btnConfirmarFechoCaixa.prop('disabled', true);
        mostrarMensagem('Enviando informações para fechar o caixa...', true);

        fetch(fecharUrl, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
          },
          body: JSON.stringify(payload),
        })
          .then((resposta) => resposta.json())
          .then((dados) => {
            if (dados.status === 'success') {
              mostrarMensagem('Caixa fechado com sucesso.', true);
              modalFechoCaixa.hide();
              atualizarPeriodos();
            } else {
              mostrarMensagem(dados.message || 'Ocorreu um erro ao fechar o caixa.', false);
            }
          })
          .catch(() => {
            mostrarMensagem('Não foi possível completar a operação. Verifique a sua conexão e tente novamente.', false);
          })
          .finally(() => {
            btnConfirmarFechoCaixa.prop('disabled', false);
          });
      });

      atualizarPeriodos();

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

      // Apply default filter for the current month on page load
      const today = new Date();
      const currentMonth = today.toISOString().slice(0, 7);
      $('#filtroPeriodo').val('month');
      mostrarSubFiltro('month');
      $('#subFiltro input').val(currentMonth);
      aplicarFiltro('month', currentMonth);

      tabela.on('draw', function () {
        calcularTotais();
      });

        calcularTotais();
    });
  </script>
  <script src="<?= base_url('assets/layout.js'); ?>"></script>
</body>
</html>
