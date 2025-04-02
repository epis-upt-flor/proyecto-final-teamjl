<?php
if (!isset($title)) $title = "Panel de Administración";
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($title) ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        body {
            display: flex;
            min-height: 100vh;
            overflow-x: hidden;
        }
        .sidebar {
            width: 250px;
            background-color: #343a40;
            color: white;
            flex-shrink: 0;
        }
        .sidebar a {
            color: white;
            text-decoration: none;
            display: block;
            padding: 12px 20px;
        }
        .sidebar a:hover {
            background-color: #495057;
        }
        .sidebar .active {
            background-color: #007bff;
        }
        .main-content {
            flex-grow: 1;
            background-color: #f8f9fa;
        }
        .topbar {
            background-color: white;
            border-bottom: 1px solid #dee2e6;
            padding: 12px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        footer {
            background-color: #f1f1f1;
            text-align: center;
            padding: 12px;
        }
    </style>
</head>
<body>

    <?php include("sidebar.php"); ?>

    <div class="main-content">
        <?php include("header.php"); ?>

        <div class="container py-4">
            <?php include($view); ?>
        </div>

        <?php include("footer.php"); ?>
    </div>

</body>
</html>