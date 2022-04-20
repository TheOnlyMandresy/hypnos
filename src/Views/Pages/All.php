<?php
ob_start();

    if ($current === 'booked') require_once System::root(1). 'Views/HTML/All/Booked.php';
    elseif ($current === 'rooms') require_once System::root(1). 'Views/HTML/All/Rooms.php';

$container = ob_get_clean();
?>