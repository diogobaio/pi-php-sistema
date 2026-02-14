<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Bem-Vindo' ?></title>
</head>

<body>

    <div class="container">
        <h1><?= $title ?? 'Bem-Vindo!' ?></h1>
        <p class="lenda">🎉 <?= $lenda ?? '' ?></p>

        <div class="links" style="display: flex; flex-direction: column; gap: 10px;">
            <?php if (isset($links) && is_array($links)): ?>
                <?php foreach ($links as $label => $url): ?>
                    <a href="<?= $url ?>" class="btn"><?= $label ?></a>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Nenhum link disponível.</p>
            <?php endif; ?>
        </div>
    </div>

</body>

</html>