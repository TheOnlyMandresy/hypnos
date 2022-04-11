<div class="title">
    <h1><?= $h1; ?></h1>
    <p>
        Chaque suite au design luxueux inclut des services hauts de gamme, de quoi plonger pleinement dans une atmosphère chic-romantique.
    </p>
</div>

<div class="container">

    <?php foreach ($all as $data): ?>
    <div class="box">
        <div class="texts">
            <h2><?= $data->name; ?></h2>
            <h3><?= $data->address; ?> <span><?= $data->city; ?></span></h3>
            <p><?= $data->description; ?></p>
        </div>

        <div class="buttons center">
            <button class="btn-success">
                <span><a onclick="route()" href="<?= System::getSystemInfos('url_hotel'); ?>/<?= $data->id; ?>">Voir les suites</a></span>
            </button>
        </div>
    </div>
    <?php endforeach; ?>
    
</div>