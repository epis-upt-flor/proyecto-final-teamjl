<?php  $role = $_SESSION['user_role'] ?? ''; ?>
<nav class="sidebar bg-dark p-3">
  <h5 class="text-center text-white mb-4">SISTEMA</h5>
  <ul class="nav flex-column">
    <?php if ($role==='administrador'): ?>
      <li class="nav-item"><a href="<?= url('dashboard') ?>" class="nav-link text-white">Dashboard</a></li>
      <li class="nav-item"><a href="<?= url('incidencias') ?>" class="nav-link text-white">Incidencias</a></li>
      <li class="nav-item"><a href="<?= url('empleados') ?>" class="nav-link text-white">Empleados</a></li>
      <li class="nav-item"><a href="<?= url('reporte') ?>" class="nav-link text-white">Reportes</a></li>
    <?php else: ?>
      <li class="nav-item"><a href="<?= url('incidencias') ?>" class="nav-link text-white">Mis Incidencias</a></li>
    <?php endif; ?>
    <li class="nav-item mt-auto"><a href="<?= url('auth/logout') ?>" class="nav-link text-white">Cerrar Sesión</a></li>
  </ul>
</nav>