<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Nova Venda | SIGE</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link href="<?= base_url('assets/style.css'); ?>" rel="stylesheet">
  <style>
    .toast { position: fixed; top: 20px; right: 20px; z-index: 9999; }
    #loadingSpinner {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      display: flex;
      align-items: center;
      justify-content: center;
      background: rgba(255, 255, 255, 0.7);
      z-index: 1050;
    }
  </style>
</head>
<body class="d-flex min-vh-100 bg-light text-dark">
<div id="loadingSpinner" class="d-none">
  <div class="spinner-border text-primary" role="status">
    <span class="visually-hidden">Carregando...</span>
  </div>
</div>
<?php $this->load->view('navbar'); ?>
<?php $this->load->view('sidebar'); ?>
<div class="content">
<div class="container-fluid">
      <h4 class="mb-4">Registrar Nova Venda</h4>
      <div class="card shadow-sm">
        <div class="card-body">
          <form id="vendaForm">
            <div class="mb-3">
              <label for="dataVenda" class="form-label">Data</label>
              <input type="date" class="form-control" id="dataVenda" name="data" required>
            </div>
            <div class="mb-3">
              <label for="clienteVenda" class="form-label">Cliente</label>
              <select class="form-select" id="clienteVenda" name="cliente" required></select>
            </div>
            <div class="mb-3">
              <label class="form-label">Itens</label>
              <table class="table" id="itensTable">
                <thead>
                  <tr>
                    <th>Produto/Serviço</th>
                    <th>Quantidade</th>
                    <th>Valor (Kz)</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <tr class="item-row">
                    <td>
                      <select class="form-select produto-select" name="produtos[]" required></select>
                    </td>
                    <td>
                      <input type="number" class="form-control quantidade-input" name="quantidades[]" required>
                    </td>
                    <td>
                      <input type="number" class="form-control valor-input" name="valores[]" required>
                    </td>
                    <td>
                      <button type="button" class="btn btn-danger btn-sm remove-item">&times;</button>
                    </td>
                  </tr>
                </tbody>
              </table>
              <button type="button" class="btn btn-secondary btn-sm" id="addItem"><i class="bi bi-plus"></i> Adicionar Produto</button>
            </div>
            <div class="mb-3">
              <label for="formaPagamento" class="form-label">Forma de Pagamento</label>
              <select class="form-select" id="formaPagamento" name="forma_pagamento" required>
                <option value="TPA">TPA</option>
                <option value="CASH">CASH</option>
                <option value="Cartão Sérgio">Cartão Sérgio</option>
                <option value="Cartão Weza">Cartão Weza</option>
                <option value="Outro">Outro</option>
              </select>
            </div>
            <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Registrar Venda</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <div id="toast-success" class="toast align-items-center text-bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true" style="display:none;">
    <div class="d-flex">
      <div class="toast-body">
        Venda registrada com sucesso!
      </div>
      <button type="button" class="btn-close btn-close-white me-2 m-auto" onclick="hideToast('toast-success')"></button>
    </div>
  </div>

  <div id="toast-error" class="toast align-items-center text-bg-danger border-0" role="alert" aria-live="assertive" aria-atomic="true" style="display:none;">
    <div class="d-flex">
      <div class="toast-body">
        Ocorreu um erro ao registrar a venda.
      </div>
      <button type="button" class="btn-close btn-close-white me-2 m-auto" onclick="hideToast('toast-error')"></button>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="<?= base_url('assets/layout.js'); ?>"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
  <script>
    function toggleLoading(show) {
      const spinner = document.getElementById('loadingSpinner');
      if (show) {
        spinner.classList.remove('d-none');
      } else {
        spinner.classList.add('d-none');
      }
    }

    document.addEventListener('DOMContentLoaded', async function() {
      toggleLoading(true);
      const clienteSelect = document.getElementById('clienteVenda');
      try {
        const clientesRes = await fetch('<?= site_url('clientes/todos'); ?>');
        const clientes = await clientesRes.json();
        clientes.forEach(c => {
          const option = document.createElement('option');
          option.value = c.nome;
          option.textContent = c.nome;
          clienteSelect.appendChild(option);
        });
      } catch (e) {}

      const itensTable = document.getElementById('itensTable').querySelector('tbody');
      const addItemBtn = document.getElementById('addItem');
      let produtosDB = [];
      try {
        const produtosRes = await fetch('<?= site_url('produtos/todos'); ?>');
        produtosDB = await produtosRes.json();
        populateProdutos(document.querySelector('.produto-select'));
      } catch (e) {}

      function populateProdutos(select) {
        select.innerHTML = '';
        produtosDB.forEach(p => {
          const option = document.createElement('option');
          option.value = p.nome;
          option.textContent = p.nome;
          option.dataset.preco = p.preco;
          select.appendChild(option);
        });
      }

      function attachEvents(row) {
        const select = row.querySelector('.produto-select');
        const valorInput = row.querySelector('.valor-input');
        select.addEventListener('change', function() {
          const selected = this.options[this.selectedIndex];
          valorInput.value = selected ? selected.dataset.preco : '';
        });
        row.querySelector('.remove-item').addEventListener('click', () => {
          if (itensTable.rows.length > 1) {
            row.remove();
          }
        });
      }

      attachEvents(document.querySelector('.item-row'));

      addItemBtn.addEventListener('click', () => {
        const newRow = document.querySelector('.item-row').cloneNode(true);
        populateProdutos(newRow.querySelector('.produto-select'));
        newRow.querySelector('.quantidade-input').value = '';
        newRow.querySelector('.valor-input').value = '';
        itensTable.appendChild(newRow);
        attachEvents(newRow);
      });

      const form = document.getElementById('vendaForm');
      const submitBtn = form.querySelector('button[type="submit"]');
      const dataInput = document.getElementById('dataVenda');

      function isFutureDate(value) {
        if (!value) {
          return false;
        }
        const selected = new Date(value + 'T00:00:00');
        const today = new Date();
        today.setHours(0, 0, 0, 0);
        return selected > today;
      }

      form.addEventListener('submit', function(e) {
        e.preventDefault();
        if (isFutureDate(dataInput.value)) {
          alert('Não é possível registrar uma venda com data futura.');
          return;
        }
        const formData = new FormData(form);
        submitBtn.disabled = true;
        toggleLoading(true);
        fetch('<?= site_url('caixa/registrar_venda'); ?>', {
          method: 'POST',
          body: formData
        })
        .then(response => response.json())
        .then(data => {
          if (data.status === 'success') {
            if (confirm('Deseja imprimir a factura em PDF?')) {
              gerarPdf(data);
            }
            showToast('toast-success');
            setTimeout(() => {
              window.location.href = "<?= site_url('produtos/lista'); ?>";
            }, 3000);
          } else {
            showToast('toast-error');
          }
        })
        .catch(() => showToast('toast-error'))
        .finally(() => {
          submitBtn.disabled = false;
          toggleLoading(false);
        });
      });
      toggleLoading(false);
    });

    function showToast(id) {
      const toast = document.getElementById(id);
      toast.style.display = 'block';
      setTimeout(() => { toast.style.display = 'none'; }, 3000);
    }

    async function getBase64ImageFromURL(url) {
      const response = await fetch(url);
      const blob = await response.blob();
      return new Promise((resolve, reject) => {
        const reader = new FileReader();
        reader.onerror = reject;
        reader.onload = () => resolve(reader.result);
        reader.readAsDataURL(blob);
      });
    }

    function formatCurrency(value) {
      return Number(value).toLocaleString('pt-PT', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
      }) + ' kz';
    }

    async function gerarPdf(venda) {
      const logo = await getBase64ImageFromURL('<?= base_url('assets/logo.jpeg'); ?>');
      let total = 0;
      const body = [
        [
          { text: 'Descrição', bold: true },
          { text: 'Unidade', bold: true },
          { text: 'Quantidade', bold: true },
          { text: 'Taxa', bold: true },
          { text: 'Montante', bold: true }
        ]
      ];
      venda.vendas.forEach(item => {
        const montante = Number(item.quantidade) * Number(item.valor);
        total += montante;
        body.push([
          item.produto,
          'un',
          item.quantidade,
          formatCurrency(item.valor),
          formatCurrency(montante)
        ]);
      });
      const numero = venda.vendas.length > 0 ? venda.vendas[0].id : 0;
      const docDefinition = {
        content: [
          {
            columns: [
              {
                stack: [
                  { image: logo, width: 80, margin: [0, 0, 0, 5] },
                  { text: 'Felase KB - Prestação de Serviços e Comércio Geral', bold: true },
                  { text: '5000789470' },
                  { text: 'Morro Bento, Luanda, Luanda, Angola' },
                  { text: '930 748 735' }
                ]
              },
              { text: 'FATURA', style: 'invoiceTitle', alignment: 'right' }
            ]
          },
          { text: '\|' },
          {
            columns: [
              {
                width: '*',
                stack: [
                  { text: 'Facturar a', bold: true, margin: [0, 0, 0, 5] },
                  { text: venda.cliente }
                ]
              },
              {
                width: 'auto',
                table: {
                  body: [
                    [{ text: 'Número da factura', bold: true }, `INV-${String(numero).padStart(4, '0')}`],
                    [{ text: 'Data da factura', bold: true }, venda.data],
                    [{ text: 'Data de vencimento', bold: true }, venda.data]
                  ]
                },
                layout: 'noBorders'
              }
            ]
          },
          { text: '\|' },
          {
            table: {
              widths: ['*', 'auto', 'auto', 'auto', 'auto'],
              body: body
            }
          },
          {
            columns: [
              { text: '', width: '*' },
              {
                width: 'auto',
                table: {
                  body: [
                    [{ text: 'Subtotal', bold: true }, formatCurrency(total)],
                    [{ text: 'Total', bold: true }, formatCurrency(total)]
                  ]
                },
                layout: 'noBorders'
              }
            ]
          },
          { text: 'Notas', style: 'notesTitle', margin: [0, 20, 0, 3] },
          { text: 'Mais do que assistência, oferecemos soluções.', margin: [0, 0, 0, 10] },
          { text: 'Obrigado pela preferência! Conte sempre connosco.', style: 'notesTitle' }
        ],
        styles: {
          invoiceTitle: { fontSize: 20, bold: true },
          notesTitle: { bold: true }
        },
        defaultStyle: { fontSize: 10 }
      };
      pdfMake.createPdf(docDefinition).open();
    }

    function hideToast(id) {
      document.getElementById(id).style.display = 'none';
    }
  </script>
</body>
</html>
