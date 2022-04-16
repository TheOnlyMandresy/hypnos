<?php
    use System\Tools\FormTool;
    $form = new FormTool();
?>

<div class="title">
    <h1><?= $h1; ?></h1>
</div>

<ul class="quickNav">
    <p class="btn-success2">
        <span><a href="/admin/hotels" onclick="route()">Hôtels</a></span>
    </p>
    <p class="btn-success2 selected">
        <span><a>Suites</a></span>
    </p>
    <p class="btn-success2">
        <span><a href="/admin/reservations" onclick="route()">Réservations</a></span>
    </p>
</ul>

<div class="container">
    <div class="list">

    </div>

    <form>
        <?= $form::input('input', 'name', 'Nom de l\'hôtel'); ?>
        <?= $form::input('input', 'city', 'Dans quelle ville est-il situé ?'); ?>
        <?= $form::input('input', 'address', 'Quel est son adresse ?'); ?>
        <?= $form::textarea('description', 'Parlez-nous de cet endroit'); ?>
        <?= $form::input('input', 'entertainment', 'Quels sevices proposez-vous (séparer par des “.”)'); ?>

        <div class="buttons">
            <?= $form::button('Attribuer les droits', 'adminInstitutionNew', 'success'); ?>
        </div>
    </form>
</div>