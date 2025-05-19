<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title><?= htmlspecialchars($title ?? 'Panel') ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
    rel="stylesheet"
  >
  <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0"></script>
  <style>
    .sidebar {
      position: fixed;
      top: 0;
      left: 0;
      width: 250px;
      height: 100vh;  
      overflow-y: auto;     
      background-color: #343a40;
      color: white;
      z-index: 1000;       
    }

    .main-content {
      margin-left: 250px;
      background-color: #f8f9fa;
      min-height: 100vh;
    }

    .topbar {
      position: sticky;
      top: 0;
      background-color: white;
      border-bottom: 1px solid #dee2e6;
      padding: 12px 20px;
      z-index: 900;
    }

    footer {
      background-color: #f1f1f1;
      text-align: center;
      padding: 12px;
    }
  </style>
</head>
<body>
  <?php include __DIR__ . '/partials/sidebar.php'; ?>

  <div class="main-content">
    <?php include __DIR__ . '/partials/header.php'; ?>

    <main class="container py-4">
      <?= $content ?>
    </main>

    <?php include __DIR__ . '/partials/footer.php'; ?>
  </div>
</body>
</html>