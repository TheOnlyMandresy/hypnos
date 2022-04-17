<?php
    use System\Tools\FormTool;
    $form = new FormTool();
?>

<div class="title">
    <h1><?= $h1; ?></h1>
</div>

<div class="container">
    <div class="team">
    <?php if ($team !== false): ?>
        <?php foreach ($team as $data): ?>
        <div id="member<?= $data->id; ?>" class="box">
            <p class="name"><?= $data->lastname; ?> <?= $data->firstname; ?></p>
            <p class="email"><?= $data->email; ?></p>
            
            <div class="buttons">
                <button class="btn-success">
                    <span><a name="get" data-infos="<?= $data->email; ?>" >modifier</a></span>
                </button>
                <button class="btn-danger">
                    <span><a name="delete" data-infos="<?= $data->email; ?>">ou retirer</a></span>
                </button>
            </div>
        </div>
        <?php endforeach; ?>
    <?php endif; ?>
    </div>
    <form>
        <?= $form::input('input', 'email', 'adresse mail du nouveau gérant'); ?>
        <?= $form::select('institutionId', 'De quel hôtel possédera-t-il la charge ?', $institutions); ?>

        <div class="buttons">
            <?= $form::button('Attribuer les droits', 'new', 'success'); ?>
        </div>
    </form>
</div>