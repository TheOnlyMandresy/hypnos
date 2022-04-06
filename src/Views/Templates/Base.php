<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title><?= $title; ?></title>
    <link rel="stylesheet" href="/css/structure.css" />
</head>

<body>
    <?php if (isset($_SESSION['flash'])): ?>
    <div class="flash">
        <div class="blur"></div>
        <p class="content-<?= $_SESSION['flash']['type']; ?>">
            <?= $_SESSION['flash']['message']; ?>
        </p>
    </div>
    <?php endif; ?>

    <main><?= $main; ?></main>
</body>

</html>

<!-- 
.------.
|K.--. |
| :/\: |
| :\/: |
| '--'H|
`------'
-->