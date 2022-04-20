<?php
    use System\Tools\FormTool;
    $form = new FormTool();
?>

<div class="list">
<?php foreach ($rooms as $data): ?>
    <div id="room<?= $data->id; ?>" class="box">
        <h2><?= $data->title; ?></h2>
        <p><?= $data->institutionName; ?></p>
        
        <div class="buttons">
            <button class="btn-success">
                <span><a name="get" data-infos="<?= $data->id; ?>" >modifier</a></span>
            </button>
            <button class="btn-danger">
                <span><a name="delete" data-infos="<?= $data->id; ?>">ou retirer</a></span>
            </button>
        </div>
    </div>
<?php endforeach; ?>
    
    <p class="btn-success2">
        <span>
            <a href="/admin/rooms" onclick="route()">ajouter une nouvelle suite</a>
        </span>
    </p>
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