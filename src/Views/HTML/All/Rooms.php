<?php use System\Tools\FormTool; ?>

<div class="container">
    <div class="search"><?= FormTool::select('institution', 'Filtrer par hôtel', $institutions); ?></div>

    <div class="list">
    <?php foreach ($datas as $data): ?>
        <div class="box">
            <img src="<?= System::getSystemInfos('img_room'); ?>/<?= $data->imgFront; ?>" />
        
            <div class="texts">
                <h2><?= $data->title; ?></h2>
                <p class="description"><?= $data->description; ?></p>
                <p><?= $data->address; ?>, <?= $data->city; ?></p>

                <div class="buttons">
                    <button class="btn-success">
                        <span><a onclick="route()" href="<?= System::getSystemInfos('url_room'); ?>/<?= $data->id; ?>">
                            en savoir plus
                        </a></span>
                    </button>
                    <button class="btn-success2">
                        <span><a href="<?= $data->link; ?>" target="_blank">
                            sur tripadvisor
                        </a></span>
                    </button>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
    </div>
</div>