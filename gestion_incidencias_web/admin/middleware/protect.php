<?php
    if (in_array($_GET['path'] ?? '', ['auth/login','auth/register'])) {
        return;
    }

    if (empty($_SESSION['admin_id'])) {
        header('Location: ' . url('auth/login'));
        exit;
    }
?>