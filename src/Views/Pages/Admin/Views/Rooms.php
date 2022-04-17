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
        <?= $form::input('input', 'title', 'Titre de la suite'); ?>
        <?= $form::select('institutionId', 'A quelle enseigne appartient-elle ?', $institutions); ?>
        <?= $form::images('Image de présentation', false); ?>
        <?= $form::textarea('description', 'Description de la suite'); ?>
        <?= $form::input('input', 'price', '€'); ?>
        <?= $form::images('Images de démonstration'); ?>
        <?= $form::input('input', 'link', 'Lien tripadvisor'); ?>

        <div class="buttons">
            <?= $form::button('Ajouter la suite', 'new', 'success'); ?>
        </div>
    </form>
</div>