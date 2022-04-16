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
    <p class="btn-success2">
        <span><a href="/admin/reservations" onclick="route()">Réservations</a></span>
    </p>
</ul>

<div class="container">
    <?php foreach ($institutions as $data): ?>
        <?php
            $roomsCount = 0;
            foreach ($rooms as $toCount) {
                if ($toCount->institutionId === $data->id) $roomsCount++;
            }
        ?>
    <div class="box">
        <h2><?= $data->name; ?></h2>
        <p><?= $roomsCount; ?> Suites, X Réservations</p>
    </div>
    <?php endforeach; ?>
</div>