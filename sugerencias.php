<?php
$tema = $_GET['tema'] ?? 'claro';
$claseTema = $tema === 'oscuro' ? 'oscuro' : 'claro';

$errores = [];
$sugerencia = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre'] ?? '');
    $categoria = trim($_POST['categoria'] ?? '');
    $descripcion = trim($_POST['descripcion'] ?? '');

    if (empty($nombre)) {
        $errores['nombre'] = 'El nombre es obligatorio.';
    }
    if (empty($categoria)) {
        $errores['categoria'] = 'La categoria es obligatoria.';
    }
    if (empty($descripcion)) {
        $errores['descripcion'] = 'La descripcion es obligatoria.';
    }
    if (empty($errores)) {
        $sugerencia = (object) [
            'nombre' => $nombre,
            'categoria' => $categoria,
            'descripcion' => $descripcion,
        ];
    }
}

$pageTitle = "Sugerir Pelicula";
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle) ?></title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body class="<?= $claseTema ?>">

    <h1 class="sugerir">Sugerir una Pelicula</h1>

    <form class="form-sugerencia" method="POST">
        <label for="nombre">Nombre de la Pelicula:</label>
        <input type="text" id="nombre" name="nombre" required placeholder="Ej: Mi Pelicula Favorita" value="<?= htmlspecialchars($_POST['nombre'] ?? '') ?>">
        <?php if (isset($errores['nombre'])) { ?>
            <div class="error"><?= htmlspecialchars($errores['nombre']) ?></div>
        <?php } ?>

        <label for="categoria">Categoria:</label>
        <input type="text" id="categoria" name="categoria" required placeholder="Ej: Mi Categoria Favorita" value="<?= htmlspecialchars($_POST['categoria'] ?? '') ?>">
        <?php if (isset($errores['nombre'])) { ?>
            <div class="error"><?= htmlspecialchars($errores['nombre']) ?></div>
        <?php } ?>

        <label for="descripcion">Descripcion:</label>
        <textarea id="descripcion" name="descripcion" required rows="4" placeholder="Breve descripcion de la pelicula..."><?= htmlspecialchars($_POST['descripcion'] ?? '') ?></textarea>
        <?php if (isset($errores['descripcion'])) { ?>
            <div class="error"><?= htmlspecialchars($errores['descripcion']) ?></div>
        <?php } ?>

        <button type="submit">Enviar Sugerencia</button>
    </form>

    <?php if ($sugerencia) { ?>
        <div class="confirmacion">
            <h2>Sugerencia Recibida!</h2>
            <p><strong>Nombre:</strong> <?= htmlspecialchars($sugerencia->nombre) ?></p>
            <p><strong>Categoria:</strong> <?= htmlspecialchars($sugerencia->categoria) ?></p>
            <p><strong>Descripcion:</strong> <?= htmlspecialchars($sugerencia->descripcion) ?></p>
            <p>Gracias por tu sugerencia!</p>
        </div>
    <?php } ?>

    <a class="volver" href="index.php?tema=<?= htmlspecialchars($tema) ?>">Volver al Catalogo</a>

</body>
</html>
