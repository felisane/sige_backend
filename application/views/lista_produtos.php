<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Lista de Produtos | SIGE</title>
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
      <h4 class="mb-4">Lista de Produtos</h4>

      <?php
        $totalSemEstoque = isset($produtos_sem_estoque) && (is_array($produtos_sem_estoque) || $produtos_sem_estoque instanceof \Countable)
          ? count($produtos_sem_estoque)
          : 0;
        $totalMaisVendidos = isset($mais_vendidos) && (is_array($mais_vendidos) || $mais_vendidos instanceof \Countable)
          ? count($mais_vendidos)
          : 0;
      ?>

      <div class="card shadow-sm">
        <div class="card-header bg-white border-0 pb-0">
          <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-3">
            <div>
              <h5 class="mb-1">Produtos cadastrados</h5>
              <div class="d-flex flex-wrap gap-2">
                <span class="badge bg-danger-subtle text-danger-emphasis rounded-pill">
                  <i class="bi bi-exclamation-circle me-1"></i> Fora de estoque: <?= $totalSemEstoque; ?>
                </span>
                <span class="badge bg-success-subtle text-success-emphasis rounded-pill">
                  <i class="bi bi-star me-1"></i> Mais vendidos: <?= $totalMaisVendidos; ?>
                </span>
              </div>
            </div>
            <div class="d-flex flex-wrap gap-2">
              <button type="button" class="btn btn-outline-danger" id="filterOutOfStock" aria-pressed="false">
                <i class="bi bi-exclamation-circle me-1"></i> Fora de estoque
              </button>
              <button type="button" class="btn btn-outline-success" id="filterTopSellers" aria-pressed="false">
                <i class="bi bi-star me-1"></i> Mais vendidos
              </button>
              <button type="button" class="btn btn-outline-secondary" id="clearFilters" disabled>
                <i class="bi bi-x-circle me-1"></i> Limpar filtros
              </button>
            </div>
          </div>
          <p class="text-muted small mb-0 mt-3">Utilize os filtros para destacar rapidamente produtos fora de estoque ou os mais vendidos diretamente na tabela principal.</p>
        </div>
        <div class="card-body">
          <div class="table-responsive">
          <table class="table table-bordered table-striped datatable" id="tabelaProdutos">
            <thead class="table-light">
              <tr>
                <th>#</th>
                <th>Imagem</th>
                <th>Produto</th>
                <th>Categoria</th>
                <th>Preço</th>
                <th>Estoque</th>
                <th>Ações</th>
              </tr>
            </thead>
            <tbody>
              <?php if (!empty($produtos)): ?>
                <?php $maisVendidosMapa = isset($mais_vendidos_mapa) ? $mais_vendidos_mapa : []; ?>
                <?php foreach ($produtos as $produto): ?>
                  <?php
                    $estoqueAtual = (int) $produto->estoque;
                    $estaSemEstoque = $estoqueAtual <= 0;
                    $totalVendido = isset($maisVendidosMapa[$produto->id]) ? (int) $maisVendidosMapa[$produto->id] : 0;
                    $rowClasses = [];

                    if ($estaSemEstoque) {
                        $rowClasses[] = 'table-danger';
                        $rowClasses[] = 'produto-sem-estoque';
                    }

                    if ($totalVendido > 0) {
                        if (!$estaSemEstoque) {
                            $rowClasses[] = 'table-success';
                        }
                        $rowClasses[] = 'produto-mais-vendido';
                    }
                  ?>
                  <tr<?php if (!empty($rowClasses)): ?> class="<?= implode(' ', $rowClasses); ?>"<?php endif; ?>>
                    <td><?= $produto->id; ?></td>
                    <td><img src="<?= base_url('uploads/' . $produto->imagem); ?>" alt="<?= $produto->nome; ?>" class="img-thumbnail" style="width:50px;cursor:pointer;" data-bs-toggle="modal" data-bs-target="#imageModal" data-image="<?= base_url('uploads/' . $produto->imagem); ?>"></td>
                    <td>
                      <?= $produto->nome; ?>
                      <?php if ($totalVendido > 0): ?>
                        <span class="badge bg-success ms-2"><i class="bi bi-star-fill me-1"></i>Mais vendido</span>
                      <?php endif; ?>
                    </td>
                    <td><?= $produto->categoria; ?></td>
                    <td>Kz <?= number_format($produto->preco, 2, ',', '.'); ?></td>
                    <td>
                      <?= $estoqueAtual; ?>
                      <?php if ($estaSemEstoque): ?>
                        <span class="badge bg-danger ms-2"><i class="bi bi-exclamation-triangle me-1"></i>Sem estoque</span>
                      <?php endif; ?>
                    </td>
                    <td>
                      <button class="btn btn-sm btn-info me-1" data-bs-toggle="modal" data-bs-target="#infoModal" data-nome="<?= $produto->nome; ?>" data-descricao="<?= $produto->descricao; ?>"><i class="bi bi-info-circle"></i></button>
                      <button class="btn btn-sm btn-primary me-1" onclick="window.location.href='<?= site_url('produtos/editar/' . $produto->id); ?>'"><i class="bi bi-pencil"></i></button>
                      <button class="btn btn-sm btn-danger me-1" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal" data-id="<?= $produto->id; ?>"><i class="bi bi-trash"></i></button>
                      <button class="btn btn-sm btn-secondary" data-bs-toggle="modal" data-bs-target="#historyModal"><i class="bi bi-clock-history"></i></button>
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php endif; ?>
            </tbody>
          </table>
          </div>
        </div>
      </div>
    </div>

  </div>

  <!-- Modal de confirmação de exclusão -->
  <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="confirmDeleteLabel">Confirmar Exclusão</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          Tem certeza que deseja apagar este produto?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="button" class="btn btn-danger">Apagar</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal de histórico do produto -->
  <div class="modal fade" id="historyModal" tabindex="-1" aria-labelledby="historyLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="historyLabel">Histórico do Produto</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <ul class="list-group">
            <li class="list-group-item">01/01/2024 - Produto cadastrado.</li>
            <li class="list-group-item">15/01/2024 - Estoque atualizado.</li>
          </ul>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal de informações do produto -->
  <div class="modal fade" id="infoModal" tabindex="-1" aria-labelledby="infoLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="infoLabel"></h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" id="infoDescricao"></div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal de pré-visualização da imagem -->
  <div class="modal fade" id="imageModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
        <div class="modal-body p-0">
          <img id="modalImage" src="" class="img-fluid w-100" alt="Pré-visualização">
        </div>
      </div>
    </div>
  </div>

  <!-- Loading overlay -->
  <div id="loadingOverlay" class="d-none position-fixed top-0 start-0 w-100 h-100 d-flex justify-content-center align-items-center bg-white bg-opacity-75" style="z-index: 1056;">
    <div class="spinner-border text-primary" role="status">
      <span class="visually-hidden">Processando...</span>
    </div>
  </div>

  <!-- Scripts -->
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
      const tabela = $('#tabelaProdutos').DataTable();

      const filterOutOfStockBtn = document.getElementById('filterOutOfStock');
      const filterTopSellersBtn = document.getElementById('filterTopSellers');
      const clearFiltersBtn = document.getElementById('clearFilters');

      if (filterOutOfStockBtn && filterTopSellersBtn && clearFiltersBtn) {
        let currentFilter = null;

        function updateFilterButtons() {
          filterOutOfStockBtn.classList.toggle('active', currentFilter === 'outOfStock');
          filterOutOfStockBtn.setAttribute('aria-pressed', currentFilter === 'outOfStock' ? 'true' : 'false');
          filterTopSellersBtn.classList.toggle('active', currentFilter === 'topSellers');
          filterTopSellersBtn.setAttribute('aria-pressed', currentFilter === 'topSellers' ? 'true' : 'false');
          clearFiltersBtn.disabled = currentFilter === null;
        }

        $.fn.dataTable.ext.search.push(function (settings, data, dataIndex) {
          if (settings.nTable.id !== 'tabelaProdutos') {
            return true;
          }

          if (!currentFilter) {
            return true;
          }

          const row = settings.aoData[dataIndex].nTr;
          if (!row) {
            return true;
          }

          if (currentFilter === 'outOfStock') {
            return row.classList.contains('produto-sem-estoque');
          }

          if (currentFilter === 'topSellers') {
            return row.classList.contains('produto-mais-vendido');
          }

          return true;
        });

        filterOutOfStockBtn.addEventListener('click', function () {
          currentFilter = currentFilter === 'outOfStock' ? null : 'outOfStock';
          updateFilterButtons();
          tabela.draw();
        });

        filterTopSellersBtn.addEventListener('click', function () {
          currentFilter = currentFilter === 'topSellers' ? null : 'topSellers';
          updateFilterButtons();
          tabela.draw();
        });

        clearFiltersBtn.addEventListener('click', function () {
          currentFilter = null;
          updateFilterButtons();
          tabela.draw();
        });

        updateFilterButtons();
      }

        const infoModal = document.getElementById('infoModal');
        infoModal.addEventListener('show.bs.modal', function (event) {
          const button = event.relatedTarget;
          const nome = button.getAttribute('data-nome');
          const descricao = button.getAttribute('data-descricao');
          document.getElementById('infoLabel').textContent = nome;
          document.getElementById('infoDescricao').textContent = descricao;
        });

        const imageModal = document.getElementById('imageModal');
        imageModal.addEventListener('show.bs.modal', function (event) {
          const img = event.relatedTarget;
          const src = img.getAttribute('data-image');
          const alt = img.getAttribute('alt');
          const modalImg = imageModal.querySelector('#modalImage');
          modalImg.src = src;
          modalImg.alt = alt;
        });

        let produtoId;
        const confirmDeleteModal = document.getElementById('confirmDeleteModal');
        confirmDeleteModal.addEventListener('show.bs.modal', function (event) {
          const button = event.relatedTarget;
          produtoId = button.getAttribute('data-id');
        });

        const deleteBtn = confirmDeleteModal.querySelector('.btn-danger');
        deleteBtn.addEventListener('click', function () {
          if (!produtoId) return;
          $.ajax({
            url: '<?= site_url('produtos/apagar/'); ?>' + produtoId,
            type: 'POST',
            dataType: 'json',
            beforeSend: function () {
              $('#loadingOverlay').removeClass('d-none');
            },
            success: function (response) {
              if (response.status === 'success') {
                tabela.row($('button[data-id="' + produtoId + '"]').parents('tr')).remove().draw();
                bootstrap.Modal.getInstance(confirmDeleteModal).hide();
              } else {
                alert('Erro ao apagar produto.');
              }
            },
            error: function () {
              alert('Erro ao apagar produto.');
            },
            complete: function () {
              $('#loadingOverlay').addClass('d-none');
            }
          });
        });
      });
    </script>
  <script src="<?= base_url('assets/layout.js'); ?>"></script>
</body>
</html>

