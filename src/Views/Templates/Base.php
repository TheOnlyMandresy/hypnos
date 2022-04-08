<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" href="/img/favicon.ico" type="image/x-icon">

    <meta name="author" content="<?= System::getSystemInfos('website'); ?>" />
    <meta name="description" content="<?= $metaDesc; ?>" />
    
    <title><?= $title; ?></title>
    <link rel="stylesheet" href="/css/style.css" />
</head>

<body>
    <header><?php require_once 'Header.php'; ?></header>

    <main class="<?= $page; ?>"><?= $main; ?></main>

    <footer><?php require_once 'Footer.php'; ?></footer>

    <script type="module" src="/js/main.js"></script>
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