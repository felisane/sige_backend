<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Editar Produto | SIGE</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link href="../../style.css" rel="stylesheet">
</head>
<body class="d-flex min-vh-100 bg-light text-dark">
<?php include __DIR__.'/navbar.php'; ?>
<?php include __DIR__.'/sidebar.php'; ?>
<div class="content">
<div class="container-fluid">
      <h4 class="mb-4">Editar Produto</h4>
      <div class="card shadow-sm">
        <div class="card-body">
          <form>
            <div class="mb-3">
              <label for="nome" class="form-label">Nome do Produto</label>
              <input type="text" class="form-control" id="nome" value="Óleo de Motor 5W30" required autocomplete="off">
            </div>
            <div class="mb-3">
              <label for="categoria" class="form-label">Categoria</label>
              <input type="text" class="form-control" id="categoria" value="Lubrificantes" required autocomplete="off">
            </div>
            <div class="mb-3">
              <label for="preco" class="form-label">Preço</label>
              <input type="number" class="form-control" id="preco" value="8000" required autocomplete="off">
            </div>
            <div class="mb-3">
              <label for="estoque" class="form-label">Estoque</label>
              <input type="number" class="form-control" id="estoque" value="20" required autocomplete="off">
            </div>
            <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Atualizar Produto</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="../../layout.js"></script>
</body>
</html>
