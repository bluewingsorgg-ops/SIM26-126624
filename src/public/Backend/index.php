<?php

if (!isset($_SESSION['catalogo'])) {
    $_SESSION['catalogo'] = [
        1 => ['modelo' => 'Canon EOS R6 Mark II', 'tipo' => 'Mirrorless', 'preco' => 2499.00, 'stock' => 4],
        2 => ['modelo' => 'Sony Alpha A7 IV', 'tipo' => 'Mirrorless', 'preco' => 2650.00, 'stock' => 2],
        3 => ['modelo' => 'Nikon D850', 'tipo' => 'DSLR', 'preco' => 2100.00, 'stock' => 5],
        4 => ['modelo' => 'Fujifilm X100VI', 'tipo' => 'Compacta', 'preco' => 1799.00, 'stock' => 1],
        5 => ['modelo' => 'Pentax K1000', 'tipo' => 'Analógica', 'preco' => 320.00, 'stock' => 0],
    ];
}

$mensagem = "";

if (isset($_POST['comprar_id'])) {
    $id = (int) $_POST['comprar_id'];

    if (isset($_SESSION['catalogo'][$id])) {
        if ($_SESSION['catalogo'][$id]['stock'] > 0) {
            $_SESSION['catalogo'][$id]['stock']--;
            $modelo = $_SESSION['catalogo'][$id]['modelo'];
            $mensagem = "<p style='color: green;'><strong> Encomenda registada:</strong> Compraste uma {$modelo}!</p>";
        } else {
            $mensagem = "<p style='color: red;'><strong> Esgotado:</strong> Esta câmara já não tem stock.</p>";
        }
    }
}

if (isset($_POST['reset_stock'])) {
    unset($_SESSION['catalogo']);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

$filtro_tipo = $_GET['tipo'] ?? 'Todos';
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Loja de Cameras</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 800px; margin: 30px auto; padding: 0 15px; background: #f4f4f9; }
        .card { background: white; padding: 15px; margin-bottom: 12px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); display: flex; justify-content: space-between; align-items: center; }
        button { padding: 8px 14px; cursor: pointer; background: #000000; color: white; border: none; border-radius: 4px; }
        button:disabled { background: #ccc; cursor: not-allowed; }
        .filtros { margin-bottom: 20px; }
    </style>
</head>
<body>

    <h1>Equipamento - Cameras</h1>
    <p>Painel de vendas e controlo de stock em tempo real.</p>

    <?= $mensagem ?>

    <div class="filtros">
        <strong>Filtrar por categoria:</strong>
        <a href="?tipo=Todos">Todos</a> |
        <a href="?tipo=Mirrorless">Mirrorless</a> |
        <a href="?tipo=DSLR">DSLR</a> |
        <a href="?tipo=Compacta">Compacta</a> |
        <a href="?tipo=Analógica">Analógica</a>
    </div>

    <?php foreach ($_SESSION['catalogo'] as $id => $camara): ?>
        <?php 
            if ($filtro_tipo !== 'Todos' && $camara['tipo'] !== $filtro_tipo) continue; 
        ?>
        <div class="card">
            <div>
                <h3><?= $camara['modelo'] ?> <small>(<?= $camara['tipo'] ?>)</small></h3>
                <p>Preço: <strong><?= number_format($camara['preco'], 2, ',', '.') ?> €</strong> | 
                   Stock: <strong><?= $camara['stock'] ?> un.</strong></p>
            </div>

            <form method="POST">
                <input type="hidden" name="comprar_id" value="<?= $id ?>">
                <button type="submit" <?= $camara['stock'] === 0 ? 'disabled' : '' ?>>
                    <?= $camara['stock'] > 0 ? 'Comprar' : 'Esgotado' ?>
                </button>
            </form>
        </div>
    <?php endforeach; ?>

    <hr>
    <form method="POST">
        <button type="submit" name="reset_stock" style="background: #555;">Repor Stock Inicial</button>
    </form>

</body>
</html>