<?php
    use System\Tools\FormTool;
    $form = new FormTool();
?>

<div class="list">
<?php foreach ($institutions as $data): ?>
    <div id="institution<?= $data->id; ?>" class="box">
        <h2><?= $data->name; ?></h2>
        
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
</div>

<form>
    <?= $form::input('input', 'name', 'Nom de l\'hôtel'); ?>
    <?= $form::input('input', 'city', 'Dans quelle ville est-il situé ?'); ?>
    <?= $form::input('input', 'address', 'Quel est son adresse ?'); ?>
    <?= $form::textarea('description', 'Parlez-nous de cet endroit'); ?>
    <?= $form::input('input', 'entertainment', 'Quels sevices proposez-vous (séparer par des “.”)'); ?>

    <div class="buttons">
        <?= $form::button('Ajouter l\'institution', 'new', 'success'); ?>
    </div>
</form>