<div class="title">
    <h1><?= $h1; ?></h1>
</div>

<div class="container">
<?php
    if ($current === 'index') require_once System::root(1). 'Views/HTML/Admin/Support/Index.php';
    elseif ($current === 'ticket') require_once System::root(1). 'Views/HTML/Admin/Support/Ticket.php';
?>
</div>