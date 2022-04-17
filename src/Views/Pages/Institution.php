<?php ob_start(); ?>

<div class="about">
    <h3 class="title">Les services qui vous sont proposés</h3>
    <h3 class="address">Au <?= $data->address; ?></h3>
    
<?php foreach ($entertainment as $data): ?>
    <p><?= $data; ?></p>
<?php endforeach; ?>
</div>

<div class="rooms">
<?php if (isset($rooms)): ?>
<?php foreach ($rooms as $data): ?>
    <div class="box">
        <div class="img" style="background-image: url(<?= System::getSystemInfos('img_room'); ?>/<?= $data->imgFront; ?>);"></div>
        
        <div class="texts">
            <h3><?= $data->title; ?></h3>
            <p class="desc"><?= $data->description; ?></p>

            <div class="buttons">
                <button class="btn-success">
                    <span><a onclick="route()" href="<?= System::getSystemInfos('url_room'); ?>/<?= $data->id; ?>">
                        en savoir plus
                    </a></span>
                </button>
                <button class="btn-success2">
                    <span><a href="https://tripadvisor.fr" target="_blank">
                        sur tripadvisor
                    </a></span>
                </button>
            </div>
        </div>
    </div>
<?php endforeach; ?>
<?php endif; ?>
</div>

<?php $container = ob_get_clean(); ?>