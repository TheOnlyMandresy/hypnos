<?php
    use System\Tools\FormTool;
    $form = new FormTool();
?>

<div class="title">
    <h1><?= $h1; ?></h1>
</div>

<div class="container">
    <form>
        <?= $form::select('institutionId', 'Dans quel hôtel allez-vous ?', $institutions, ''); ?>
        <?= $form::select('roomId', 'Choix de la chambre', $rooms, ''); ?>
        <?= $form::date('dateStart', 'Début du séjour'); ?>
        <?= $form::date('dateEnd', 'Fin du séjour'); ?>

        <div class="buttons">
            <?= $form::button('Réserver', 'book-new', 'success'); ?>
        </div>
    </form>
</div>