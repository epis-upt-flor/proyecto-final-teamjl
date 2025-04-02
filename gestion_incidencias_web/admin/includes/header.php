<div class="topbar">
    <span><?= $title ?></span>
    <div>
        <i class="bi bi-person-circle"></i> <?= htmlspecialchars($_SESSION['admin_nombre'] ?? 'Administrador') ?>
    </div>
</div>