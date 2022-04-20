<?php ob_start(); ?>

<div class="caroussel">
    <div class="images">
        <?php for ($i = 0; $i < count($images); $i++): ?>
            <img src="<?= System::getSystemInfos('img_room'); ?>/<?= $images[$i]; ?>" />
        <?php endfor;?>
    </div>
    <div class="options">
        <p class="left"><</p>
        <p class="right">></p>
    </div>
</div>

<div class="container">
<div class="presentation">
    <div>
        <img src="<?= System::getSystemInfos('img_room'); ?>/<?= $datas->imgFront; ?>" />
    </div>
    <p><?= $datas->description; ?></p>
</div>

<div class="buttons">
    <p class="price"><?= $datas->price; ?> € la nuit</p>
    <button class="btn-success">
        <span><a name="quick" data-infos="<?= $datas->id; ?>">pour reserver</a></span>
    </button>
</div>
</div>

<?php $container = ob_get_clean(); ?>