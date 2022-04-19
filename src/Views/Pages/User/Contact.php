<?php ob_start(); ?>
    <div class="buttons">
        <button class="btn-success">
            <span><a href="/contact" onclick="route()">Créer un nouveau ticket</a></span>
        </button>
    </div>

    <div class="list">
    <?php foreach ($all as $data): ?>
        <div class="box">
            <h2>[<?= $data->stateTxt; ?>] <?= $data->title; ?></h2>
            <p><?= $data->dateCreate; ?></p>
            <div class="buttons">
                <button class="btn-success">
                    <span><a onclick="route()" href="<?= System::getSystemInfos('url_support'); ?>/<?= $data->id; ?>">voir</a></span>
                </button>
            </div>
        </div>
    <?php endforeach; ?>
    </div>

<?php $container = ob_get_clean(); ?>

<?php if (isset($datas['infos'])) require_once System::root(1). 'HTML/Support/Ticket.php'; ?>