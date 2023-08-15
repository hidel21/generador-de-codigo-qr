<?php
require 'RapidPrestAPI.php'; // Asegúrate de que la ruta sea correcta si guardaste la clase en un archivo separado
include('phpqrcode/qrlib.php');


// Verifica y crea el directorio temp/ si no existe
if (!file_exists('temp/')) {
    mkdir('temp/', 0777, true);
}

$nombre = trim($_POST['nombre']);
$cantidad = trim($_POST['cantidad']);
$telefono = trim($_POST['telefono']);

if (empty($nombre) || empty($cantidad) || empty($telefono)) {
    $error = "Todos los campos son obligatorios.";
} else {
    // Utiliza la clase RapidPrestAPI
    $api = new RapidPrestAPI();
    $response = $api->generateQR("prueba1", $cantidad, "8611");

    if ($response['state'] != 200) {
        $error = $response['message'];
    } else {
        if (isset($response['data']['codigo'])) {
            $qrCodeData = $response['data']['codigo'];

            // Genera la imagen QR
            include('phpqrcode/qrlib.php'); // Asegúrate de que la ruta sea correcta
            $tempDir = "temp/"; // Directorio temporal para guardar la imagen QR
            $fileName = 'qr_' . md5($qrCodeData) . '.png';
            $pngAbsoluteFilePath = $tempDir . $fileName;
            QRcode::png($qrCodeData, $pngAbsoluteFilePath, QR_ECLEVEL_L, 4);

            $qr_link = $pngAbsoluteFilePath;
        } else {
            $error = "Error al generar el QR.";
        }
    }
}


// Validaciones adicionales
if (empty($nombre) || strlen($nombre) > 50) {
    $error = "El nombre es obligatorio y no debe exceder los 50 caracteres.";
} elseif (empty($cantidad) || !is_numeric($cantidad) || $cantidad <= 0) {
    $error = "La cantidad es obligatoria y debe ser un número positivo.";
} elseif (empty($telefono) || !is_numeric($telefono) || strlen($telefono) != 10) {
    $error = "El teléfono es obligatorio y debe tener 10 dígitos.";
} else {
    // Aquí puedes insertar los datos en la base de datos usando consultas preparadas
    $stmt = $pdo->prepare("INSERT INTO your_table (nombre, cantidad, telefono) VALUES (:nombre, :cantidad, :telefono)");
    $stmt->bindParam(':nombre', $nombre);
    $stmt->bindParam(':cantidad', $cantidad);
    $stmt->bindParam(':telefono', $telefono);
    $stmt->execute();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Generado</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h3 class="mb-0">Resultado QR</h3>
        </div>
        <div class="card-body">
            <?php if (!empty($error)): ?>
                <div class="alert alert-danger">
                    <?= $error ?>
                </div>
            <?php elseif (isset($qr_link)): ?>
                <div class="text-center">
                    <img src="<?= $qr_link ?>" alt="QR Code" class="img-fluid mb-3">
                    <div>
                        <a href="<?= $qr_link ?>" download="qr_code.png" class="btn btn-success">Descargar QR</a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

            <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    </body>
</HTML>