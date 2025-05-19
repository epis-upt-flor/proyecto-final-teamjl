<?php ?>
<header class="topbar bg-white border-bottom p-3 d-flex justify-content-between align-items-center">
  <h4 class="m-0"><?= htmlspecialchars($title ?? '') ?></h4>
  <div class="d-flex align-items-center">
    <i class="bi bi-person-circle me-2" style="font-size: 1.5rem;"></i>
    <span><?= htmlspecialchars($_SESSION['admin_nombre'] ?? 'Administrador') ?></span>
  </div>
</header>
