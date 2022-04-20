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