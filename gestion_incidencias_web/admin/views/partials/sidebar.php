<?php // admin/views/partials/sidebar.php ?>
<nav class="sidebar bg-dark d-flex flex-column p-3">
  <h5 class="text-center text-white mb-4">ADMINISTRADOR</h5>
  <ul class="nav nav-pills flex-column mb-auto">
    <li class="nav-item mb-1">
      <a href="<?= url('dashboard') ?>"
         class="nav-link text-white <?= ($_GET['path'] ?? '') === 'dashboard' ? 'active bg-primary' : '' ?>">
        <i class="bi bi-speedometer2 me-2"></i>
        Dashboard
      </a>
    </li>
    <li class="nav-item mb-1">
      <a href="<?= url('incidencias') ?>"
         class="nav-link text-white <?= ($_GET['path'] ?? '') === 'incidencias' ? 'active bg-primary' : '' ?>">
        <i class="bi bi-exclamation-circle me-2"></i>
        Incidencias
      </a>
    </li>
    <li class="nav-item mb-1">
      <a href="<?= url('empleados') ?>"
         class="nav-link text-white <?= ($_GET['path'] ?? '') === 'empleados' ? 'active bg-primary' : '' ?>">
        <i class="bi bi-person-badge me-2"></i>
        Empleados
      </a>
    </li>
    <li class="nav-item mb-1">
      <a href="<?= url('reporte') ?>"
         class="nav-link text-white <?= ($_GET['path'] ?? '') === 'reporte' ? 'active bg-primary' : '' ?>">
        <i class="bi bi-graph-up me-2"></i>
        Reportes
      </a>
    </li>
    <li class="nav-item mt-auto">
      <a href="<?= url('auth/logout') ?>" class="nav-link text-white">
        <i class="bi bi-box-arrow-right me-2"></i>
        Cerrar Sesión
      </a>
    </li>
  </ul>
</nav>
