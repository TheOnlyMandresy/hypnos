<div class="title">
    <h1><?= $h1; ?></h1>
</div>

<ul class="quickNav">
    <p class="btn-success2 <?php if ($current === 'institutions') echo 'selected'; ?>">
        <span>
            <a <?php if ($current !== 'institutions') echo 'href="/admin/hotels" onclick="route()"'; ?>>Hôtels</a>
        </span>
    </p>
    <p class="btn-success2 <?php if ($current === 'rooms') echo 'selected'; ?>">
        <span>
            <a <?php if ($current !== 'rooms') echo 'href="/admin/rooms" onclick="route()"'; ?>>Suites</a>
        </span>
    </p>
    <p class="btn-success2 <?php if ($current === 'reservations') echo 'selected'; ?>">
        <span>
            <a <?php if ($current !== 'reservations') echo 'href="/admin/reservations" onclick="route()"'; ?>>Réservations</a>
        </span>
    </p>
</ul>

<div class="container">
<?php
    if ($current === 'index') require_once System::root(1). 'Views/HTML/Admin/Views/Index.php';
    elseif ($current === 'institutions') require_once System::root(1). 'Views/HTML/Admin/Views/Institutions.php';
    elseif ($current === 'rooms') require_once System::root(1). 'Views/HTML/Admin/Views/Rooms.php';
    elseif ($current === 'reservations') require_once System::root(1). 'Views/HTML/Admin/Views/Reservations.php';
?>
</div>