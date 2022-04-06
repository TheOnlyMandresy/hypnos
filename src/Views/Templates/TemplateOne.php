<?php ob_start(); ?>
    <div class="contentOne">
        <?= $contentOne; ?>
    </div>
<?php $body = ob_get_clean();

require_once 'Base.php';
?>