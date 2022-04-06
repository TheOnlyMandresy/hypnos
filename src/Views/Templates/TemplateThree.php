<?php ob_start(); ?>
    <div class="top margin">
        <?= $contentTop; ?>
    </div>
    <div class="left margin">
        <?= $contentLeft; ?>
    </div>
    <div class="right">
        <?= $contentRight; ?>
    </div>
<?php $body = ob_get_clean(); ?>

<?php require_once 'Base.php'; ?>