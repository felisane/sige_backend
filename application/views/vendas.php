<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Vendas | SIGE</title>
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
    <h3>Vendas</h3>
    <div class="table-responsive">
      <table class="table table-bordered table-striped datatable" id="tabelaVendas">
        <thead>
          <tr>
            <th>Nº</th>
            <th>Data</th>
            <th>Cliente</th>
            <th>Produto</th>
            <th>Quantidade</th>
            <th>Valor (Kz)</th>
            <th>Ações</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($vendas as $v): ?>
          <tr
            data-id="<?= $v->id; ?>"
            data-data="<?= $v->data; ?>"
            data-cliente="<?= htmlspecialchars($v->cliente, ENT_QUOTES, 'UTF-8'); ?>"
            data-produto="<?= htmlspecialchars($v->produto, ENT_QUOTES, 'UTF-8'); ?>"
            data-descricao="<?= htmlspecialchars($v->descricao, ENT_QUOTES, 'UTF-8'); ?>"
            data-quantidade="<?= $v->quantidade; ?>"
            data-valor="<?= $v->valor; ?>"
          >
            <td><?= $v->id; ?></td>
            <td><?= date('d/m/Y', strtotime($v->data)); ?></td>
            <td><?= $v->cliente; ?></td>
            <td><?= $v->produto; ?></td>
            <td><?= $v->quantidade; ?></td>
            <td data-order="<?= $v->valor * $v->quantidade; ?>">
              <?= number_format($v->valor * $v->quantidade, 2, ',', '.'); ?>
            </td>
            <td>
              <div class="btn-group" role="group">
                <button class="btn btn-sm btn-outline-primary imprimir" title="Imprimir"><i class="bi bi-printer"></i></button>
                <?php if (!empty($is_admin) && $is_admin): ?>
                <button class="btn btn-sm btn-outline-danger apagar" title="Apagar"><i class="bi bi-trash"></i></button>
                <?php endif; ?>
              </div>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="<?= base_url('assets/tables.js'); ?>"></script>
<script src="<?= base_url('assets/layout.js'); ?>"></script>
<script>
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
      const total = Number(venda.quantidade) * Number(venda.valor);
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
              { text: 'FACTURA', style: 'invoiceTitle', alignment: 'right' }
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
                    [{ text: 'Número da factura', bold: true }, `INV-${String(venda.id).padStart(4, '0')}`],
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
              body: [
                [
                  { text: 'Descrição', bold: true },
                  { text: 'Unidade', bold: true },
                  { text: 'Quantidade', bold: true },
                  { text: 'Taxa', bold: true },
                  { text: 'Montante', bold: true }
                ],
                [
                  venda.descricao ? venda.descricao : venda.produto,
                  'un',
                  venda.quantidade,
                  formatCurrency(venda.valor),
                  formatCurrency(total)
                ]
              ]
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

  $(document).ready(function () {
    const tabela = $('#tabelaVendas').DataTable();

    $('#tabelaVendas').on('click', 'button.imprimir', function () {
      const tr = this.closest('tr');
      const venda = {
        id: tr.dataset.id,
        data: tr.dataset.data,
        cliente: tr.dataset.cliente,
        produto: tr.dataset.produto,
        descricao: tr.dataset.descricao,
        quantidade: tr.dataset.quantidade,
        valor: tr.dataset.valor
      };
      gerarPdf(venda);
    });

    <?php if (!empty($is_admin) && $is_admin): ?>
    $('#tabelaVendas').on('click', 'button.apagar', function () {
      const tr = this.closest('tr');
      const vendaId = tr.dataset.id;

      if (!confirm('Deseja realmente apagar esta venda?')) {
        return;
      }

      fetch('<?= site_url('vendas/apagar'); ?>/' + vendaId, {
        method: 'POST',
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
      })
        .then(response => response.json().then(data => ({ status: response.status, body: data })))
        .then(({ status, body }) => {
          if (status >= 200 && status < 300 && body.status === 'success') {
            tabela.row($(tr)).remove().draw();
            alert('Venda apagada com sucesso.');
          } else {
            alert(body.message || 'Não foi possível apagar a venda.');
          }
        })
        .catch(() => {
          alert('Ocorreu um erro ao tentar apagar a venda.');
        });
    });
    <?php endif; ?>
  });
</script>
</body>
</html>
