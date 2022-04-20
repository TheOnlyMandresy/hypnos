<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" href="/img/favicon.ico" type="image/x-icon" />

    <meta name="author" content="<?= System::getSystemInfos('website'); ?>" />
    <meta name="description" content="<?= System::getSystemInfos('meta_desc'); ?>" />
    
    <meta name="twitter:card" content="summary" />
    <meta name="twitter:site" content="<?= System::getSystemInfos('website'); ?>" />
    <meta name="twitter:creator" content="<?= System::getSystemInfos('website'); ?>" />

    <meta property="og:image" content="/img/<?= System::getSystemInfos('meta_img'); ?>" />
    <meta property="og:description" content="<?= System::getSystemInfos('meta_desc'); ?>" />
    <meta property="og:title" content="<?= System::getSystemInfos('website'); ?>" />
    
    <title><?= System::getSystemInfos('website'); ?></title>
    <link rel="stylesheet" href="/css/new css/style.css" />
</head>

<body>
    <?php require_once 'Loading.php'; ?>

    <header><?php require_once 'Header.php'; ?></header>

    <div id="root"></div>

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