<?php
$items = require_once ('data/items.php');

$tema = $_GET['tema'] ?? 'claro';
$claseTema = $tema === 'oscuro' ? 'oscuro' : 'claro';

$pageTitle= "Titulo de prueba";

$busqueda = "";
$categoria = "";
$page = "home";
$list = $items;

if (isset($_GET["page"])) {
    $page = $_GET["page"];
}

if (isset($_GET["busqueda"])) {
    $busqueda = $_GET["busqueda"];
}
if (isset($_GET["categoria"])) {
    $categoria = $_GET["categoria"];
}
if (isset($_GET["tema"])) {
    $tema = $_GET["tema"];
}

if (!empty($busqueda)) {
    $list = array_filter($list, function($item) use ($busqueda) {
        return strpos(strtolower($item->nombre), strtolower($busqueda)) !== false;
    });
}
if (!empty($categoria)) {
    $list = array_filter($list, function($item) use ($categoria) {
        return $item->categoria === $categoria;
    });
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> <?= $pageTitle ?> </title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body class="<?= $claseTema ?>">

    <h1 class="catalogo">Catálogo</h1>

    <form class="form-filtro" method="GET">
        <input type="text" name="busqueda" placeholder="Buscar por nombre..." value="<?= htmlspecialchars($busqueda) ?>">
        <select name="categoria">
            <option value="">-- Todas las categorías --</option>
            <option value="Romance" <?= $categoria === "Romance" ? "selected" : "" ?>>Romance</option>
            <option value="Crimen" <?= $categoria === "Crimen" ? "selected" : "" ?>>Crimen</option>
            <option value="Infantil" <?= $categoria === "Infantil" ? "selected" : "" ?>>Infantil</option>
            <option value="Terror" <?= $categoria === "Terror" ? "selected" : "" ?>>Terror</option>
        </select>
        <select name="tema" onchange="this.form.submit()">
            <option value="claro" <?= $tema === "claro" ? "selected" : "" ?>>Tema claro</option>
            <option value="oscuro" <?= $tema === "oscuro" ? "selected" : "" ?>>Tema oscuro</option>
        </select>
        <button type="submit">Filtrar</button>
        <a href= "sugerencias.php?tema=<?= htmlspecialchars($tema) ?>" class="btn-sugerir">Sugerir una Película</a>
    </form>
    <div class="contenedor-tarjetas">
        <?php if (empty($list)): ?>
            <p>No se encontraron items que coincidan con la busqueda/filtro.</p>
        <?php else: ?>
            <?php foreach ($list as $item): ?>
                <div class="tarjeta">
                    <img src="<?php echo htmlspecialchars($item->imagen); ?>" alt="<?php echo htmlspecialchars($item->nombre); ?>" loading="lazy">
                    <h3><?php echo htmlspecialchars($item->nombre); ?></h3>
                    <span class="categoria"><?php echo htmlspecialchars($item->categoria); ?></span>
                    <p><?php echo htmlspecialchars($item->descripcion); ?></p>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</body>
</html>