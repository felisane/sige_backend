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
  </style>
</head>
<body class="d-flex min-vh-100 bg-light text-dark">
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
              <input type="text" class="form-control" id="clienteVenda" name="cliente" list="clientesList" placeholder="Digite o nome do cliente" required>
              <datalist id="clientesList"></datalist>
            </div>
            <div class="mb-3">
              <label for="produtoVenda" class="form-label">Produto/Serviço</label>
              <input type="text" class="form-control" id="produtoVenda" name="produto" list="produtosList" placeholder="Digite ou selecione o produto" required>
              <datalist id="produtosList"></datalist>
            </div>
            <div class="mb-3 d-none" id="servicoDescricaoDiv">
              <label for="descricaoServico" class="form-label">Descrição do Serviço</label>
              <input type="text" class="form-control" id="descricaoServico" name="descricao" placeholder="Descreva o serviço">
            </div>
            <div class="mb-3">
              <label for="quantidadeVenda" class="form-label">Quantidade</label>
              <input type="number" class="form-control" id="quantidadeVenda" name="quantidade" required>
            </div>
            <div class="mb-3">
              <label for="valorVenda" class="form-label">Valor (Kz)</label>
              <input type="number" class="form-control" id="valorVenda" name="valor" required>
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
  <script>
    document.addEventListener('DOMContentLoaded', async function() {
      const clienteList = document.getElementById('clientesList');
      try {
        const clientesRes = await fetch('<?= site_url('clientes/todos'); ?>');
        const clientes = await clientesRes.json();
        clientes.forEach(c => {
          const option = document.createElement('option');
          option.value = c.nome;
          option.dataset.id = c.id;
          clienteList.appendChild(option);
        });
      } catch (e) {}

      const produtoInput = document.getElementById('produtoVenda');
      const produtoList = document.getElementById('produtosList');
      let produtosDB = [];
      try {
        const produtosRes = await fetch('<?= site_url('produtos/todos'); ?>');
        produtosDB = await produtosRes.json();
        produtosDB.forEach(p => {
          const option = document.createElement('option');
          option.value = p.nome;
          option.dataset.id = p.id;
          option.dataset.preco = p.preco;
          produtoList.appendChild(option);
        });
      } catch (e) {}

      const valorInput = document.getElementById('valorVenda');
      const descDiv = document.getElementById('servicoDescricaoDiv');
      const descInput = document.getElementById('descricaoServico');

      produtoInput.addEventListener('input', function() {
        const prod = produtosDB.find(p => p.nome.toLowerCase() === this.value.toLowerCase());
        if (prod) {
          descDiv.classList.add('d-none');
          descInput.required = false;
          valorInput.value = prod.preco;
        } else {
          descDiv.classList.remove('d-none');
          descInput.required = true;
          valorInput.value = '';
        }
      });

      const form = document.getElementById('vendaForm');
      form.addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(form);
        fetch('<?= site_url('caixa/registrar_venda'); ?>', {
          method: 'POST',
          body: formData
        })
        .then(response => response.json())
        .then(data => {
          if (data.status === 'success') {
            showToast('toast-success');
            setTimeout(() => {
              window.location.href = "<?= site_url('produtos/lista'); ?>";
            }, 3000);
            descDiv.classList.add('d-none');
            descInput.required = false;
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
