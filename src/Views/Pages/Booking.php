<?php
    use System\Tools\FormTool;
    $form = new FormTool();
?>

<div class="title">
    <h1><?= $h1; ?></h1>
</div>

<div class="container">
    <form>
        <?= $form::select('institutionId', 'Dans quel hôtel allez-vous ?', $institutions, $institutionId); ?>
        <?= $form::select('roomId', 'Choix de la chambre', $rooms, $roomId); ?>
        <?= $form::date('dateStart', 'Début du séjour', $dateStart); ?>
        <?= $form::date('dateEnd', 'Fin du séjour', $dateEnd); ?>

        <div class="buttons">
            <?= $form::button('Réserver', 'new', 'success'); ?>
        </div>
    </form>
</div>