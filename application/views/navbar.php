<!--
  navbar.php
  Centralized navbar for SIGE.
  Included server-side via $this->load->view(); layout.js only handles interface behavior.
  The right side shows a user greeting and icon.
-->
<nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm px-4 fixed-top">
  <!-- Container da navbar com alinhamento -->
  <div class="container-fluid d-flex align-items-center justify-content-between">
    <span class="navbar-brand mb-0 h1">Painel de Controle</span>
    <!-- Área da navbar com saudação do usuário -->
    <div class="d-flex align-items-center">
      <!-- User profile icon and greeting -->
      <i class="bi bi-person-circle fs-3 me-2 text-primary"></i>
      <span>Olá, <?= html_escape($this->session->userdata('username')); ?></span>
      <a href="<?= site_url('auth/logout'); ?>" class="btn btn-sm btn-outline-secondary ms-3">Sair</a>
    </div>
  </div>
</nav>
