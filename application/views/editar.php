<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Editar Cliente | SIGE</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link href="../../style.css" rel="stylesheet">
</head>
<body class="d-flex min-vh-100 bg-light text-dark">
<?php include __DIR__.'/navbar.php'; ?>
<?php include __DIR__.'/sidebar.php'; ?>
<div class="content">
<div class="container-fluid">
      <h4 class="mb-4">Editar Cliente</h4>
      <div class="card shadow-sm">
        <div class="card-body">
          <form>
            <div class="mb-3">
              <label for="nome" class="form-label">Nome completo</label>
              <input type="text" class="form-control" id="nome" value="" required autocomplete="off">
            </div>
            <div class="mb-3">
              <label for="endereco" class="form-label">Endereço</label>
              <input type="text" class="form-control" id="endereco" name="endereco" value="" required autocomplete="off">
            </div>
            <div class="mb-3">
              <label for="telefone" class="form-label">Telefone</label>
              <input type="tel" class="form-control" id="telefone" value="" required autocomplete="off">
            </div>
            <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Atualizar Cliente</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="../../layout.js"></script>
</body>
</html>

