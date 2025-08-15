<!--
  sidebar.html
  Centralized sidebar menu for SIGE.
  This file is loaded dynamically into pages via layout.js.
  Each menu item is explained below.
-->
<!-- Barra lateral com links de navegação -->
<div class="sidebar bg-dark text-white position-fixed top-0 bottom-0 d-flex flex-column p-3">
  <h4 class="text-center">SIGE</h4>
  <hr>
  <nav id="sidebar-menu" class="nav nav-pills flex-column">
    <a href="index.php?path=home" class="nav-link text-white" id="dashboard-link">
      <i class="bi bi-speedometer2 me-2"></i>Dashboard
    </a>
    <a class="nav-link text-white d-flex justify-content-between align-items-center" data-bs-toggle="collapse" href="#submenuClientes" role="button" aria-expanded="false" aria-controls="submenuClientes">
      <span><i class="bi bi-people-fill me-2"></i>Clientes</span>
      <i class="bi bi-caret-down"></i>
    </a>
    <!-- Submenu de clientes -->
    <div class="collapse ms-3" id="submenuClientes" data-bs-parent="#sidebar-menu">
      <nav class="nav nav-pills flex-column">
        <a href="index.php?path=lista_clientes" class="nav-link text-white">Lista de Clientes</a>
        <a href="index.php?path=cadastrar" class="nav-link text-white">Cadastrar Cliente</a>
      </nav>
    </div>
    <a class="nav-link text-white d-flex justify-content-between align-items-center" data-bs-toggle="collapse" href="#submenuProdutos" role="button" aria-expanded="false" aria-controls="submenuProdutos">
      <span><i class="bi bi-box-seam me-2"></i>Produtos</span>
      <i class="bi bi-caret-down"></i>
    </a>
    <!-- Submenu de produtos -->
    <div class="collapse ms-3" id="submenuProdutos" data-bs-parent="#sidebar-menu">
      <nav class="nav nav-pills flex-column">
        <a href="index.php?path=lista_produtos" class="nav-link text-white">Lista de Produtos</a>
        <a href="index.php?path=adicionar_produto" class="nav-link text-white">Adicionar Produtos</a>
      </nav>
    </div>
    <a class="nav-link text-white d-flex justify-content-between align-items-center" data-bs-toggle="collapse" href="#submenuCaixa" role="button" aria-expanded="false" aria-controls="submenuCaixa">
      <span><i class="bi bi-cash-coin me-2"></i>Caixa</span>
      <i class="bi bi-caret-down"></i>
    </a>
    <div class="collapse ms-3" id="submenuCaixa" data-bs-parent="#sidebar-menu">
      <nav class="nav nav-pills flex-column">
        <a href="index.php?path=nova_venda" class="nav-link text-white">Nova Venda</a>
        <a href="index.php?path=fluxo_caixa" class="nav-link text-white">Fluxo de Caixa</a>
      </nav>
    </div>
    <a class="nav-link text-white d-flex justify-content-between align-items-center" data-bs-toggle="collapse" href="#submenuRelatorios" role="button" aria-expanded="false" aria-controls="submenuRelatorios">
      <span><i class="bi bi-bar-chart me-2"></i>Relatórios</span>
      <i class="bi bi-caret-down"></i>
    </a>
    <div class="collapse ms-3" id="submenuRelatorios" data-bs-parent="#sidebar-menu">
      <nav class="nav nav-pills flex-column">
        <a href="index.php?path=relatorios_vendas" class="nav-link text-white">Relatórios de Vendas</a>
        <a href="index.php?path=relatorios_caixa" class="nav-link text-white">Relatórios de Caixa</a>
        <a href="index.php?path=relatorios_fiscais" class="nav-link text-white">Relatórios Fiscais</a>
        <a href="index.php?path=relatorios_estoque" class="nav-link text-white">Relatórios de Estoque</a>
      </nav>
    </div>
    <a href="#" class="nav-link text-white"><i class="bi bi-gear me-2"></i>Configurações</a>
    <a href="#" class="nav-link text-white"><i class="bi bi-box-arrow-right me-2"></i>Sair</a>
  </nav>
</div>

