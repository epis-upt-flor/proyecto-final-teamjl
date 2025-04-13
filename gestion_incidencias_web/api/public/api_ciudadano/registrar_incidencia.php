<?php
require_once __DIR__ . '/../../bootstrap.php';

use App\Controllers\CiudadanoController;

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    \App\Core\Response::error("Método no permitido", 405);
}

// Reunimos los datos del formulario (multipart/form-data)
$data = [
    'tipo_id'     => $_POST['tipo_id'] ?? null,
    'latitud'     => $_POST['latitud'] ?? null,
    'longitud'    => $_POST['longitud'] ?? null,
    'descripcion' => $_POST['descripcion'] ?? null,
    'direccion'   => $_POST['direccion'] ?? null,
    'zona'        => $_POST['zona'] ?? null,
];

// Convertimos la imagen en base64 si fue subida
if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
    $fileTmpPath = $_FILES['foto']['tmp_name'];
    $data['foto'] = base64_encode(file_get_contents($fileTmpPath));
} else {
    $data['foto'] = null;
}

CiudadanoController::registrarIncidencia($data);
?>
