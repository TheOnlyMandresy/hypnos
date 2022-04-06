<div class="navs">

<?php

if (str_contains(PAGE, 'admin')) new \Systeme\HTML\Navs\Nav(PAGE);

if ($isLogged) require_once Systeme::root(). 'Systeme/HTML/Navs/NavAdmin.php';

if (!str_contains(PAGE, 'admin')) new \Systeme\HTML\Navs\Nav(PAGE);

require_once Systeme::root(). 'Systeme/HTML/Navs/NavUser.php';
?>

</div>