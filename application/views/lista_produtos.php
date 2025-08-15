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
  <link href="../../style.css" rel="stylesheet">
</head>
<body class="d-flex min-vh-100 bg-light text-dark">
<?php include __DIR__.'/navbar.php'; ?>
<?php include __DIR__.'/sidebar.php'; ?>
<div class="content">
<div class="container-fluid">
      <h4 class="mb-4">Lista de Produtos</h4>
      <div class="card shadow-sm">
        <div class="card-body">
          <div class="table-responsive">
          <table class="table table-bordered table-striped" id="tabelaProdutos">
            <thead class="table-light">
              <tr>
                <th>#</th>
                <th>Produto</th>
                <th>Categoria</th>
                <th>Preço</th>
                <th>Estoque</th>
                <th>Ações</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>1</td>
                <td>Óleo de Motor 5W30</td>
                <td>Lubrificantes</td>
                <td>Kz 8.000</td>
                <td>20</td>
                <td>
                  <button class="btn btn-sm btn-primary me-1" onclick="window.location.href='index.php?path=editar_produto'"><i class="bi bi-pencil"></i></button>
                  <button class="btn btn-sm btn-danger me-1" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal"><i class="bi bi-trash"></i></button>
                  <button class="btn btn-sm btn-secondary" data-bs-toggle="modal" data-bs-target="#historyModal"><i class="bi bi-clock-history"></i></button>
                </td>
              </tr>
              <tr>
                <td>2</td>
                <td>Filtro de Ar</td>
                <td>Filtros</td>
                <td>Kz 2.500</td>
                <td>35</td>
                <td>
                  <button class="btn btn-sm btn-primary me-1" onclick="window.location.href='index.php?path=editar_produto'"><i class="bi bi-pencil"></i></button>
                  <button class="btn btn-sm btn-danger me-1" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal"><i class="bi bi-trash"></i></button>
                  <button class="btn btn-sm btn-secondary" data-bs-toggle="modal" data-bs-target="#historyModal"><i class="bi bi-clock-history"></i></button>
                </td>
              </tr>
              <tr>
                <td>3</td>
                <td>Pastilha de Freio</td>
                <td>Freios</td>
                <td>Kz 12.000</td>
                <td>15</td>
                <td>
                  <button class="btn btn-sm btn-primary me-1" onclick="window.location.href='index.php?path=editar_produto'"><i class="bi bi-pencil"></i></button>
                  <button class="btn btn-sm btn-danger me-1" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal"><i class="bi bi-trash"></i></button>
                  <button class="btn btn-sm btn-secondary" data-bs-toggle="modal" data-bs-target="#historyModal"><i class="bi bi-clock-history"></i></button>
                </td>
              </tr>
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
  <script>
    $(document).ready(function () {
      if (!$.fn.DataTable.isDataTable('#tabelaProdutos')) {
        $('#tabelaProdutos').DataTable({
          dom: "<'d-flex justify-content-between align-items-center flex-wrap mb-3'<'d-flex align-items-center gap-2'lf>B>rtip",
          buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
          language: {
            url: 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/pt-PT.json'
          }
        });
      }
    });
  </script>
  <script src="../../layout.js"></script>
</body>
</html>

