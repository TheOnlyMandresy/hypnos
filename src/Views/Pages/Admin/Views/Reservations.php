<div class="title">
    <h1><?= $h1; ?></h1>
</div>

<ul class="quickNav">
    <p class="btn-success2">
        <span><a href="/admin/hotels" onclick="route()">Hôtels</a></span>
    </p>
    <p class="btn-success2">
        <span><a href="/admin/rooms" onclick="route()">Suites</a></span>
    </p>
    <p class="btn-success2 selected">
        <span><a>Réservations</a></span>
    </p>
</ul>

<div class="container list">
<?php foreach ($datas as $data): ?>
    <?php
        $bookedCount = 0;
        for ($i = 0; $i < count($datas); $i++) if ($datas[$i]->roomId === $data->roomId) $bookedCount++;
    ?>

    <div class="box">
        <h2><?= $data->title; ?></h2>
        <p class="institution"><?= $data->institutionName; ?></p>
        <p class="count"><?= $bookedCount; ?> réservations</p>
    </div>
<?php endforeach; ?>
</div>