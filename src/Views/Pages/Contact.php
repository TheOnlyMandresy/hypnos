<?php
    use System\Tools\FormTool;
    $form = new FormTool();
?>

<div class="title">
    <h1><?= $h1; ?></h1>
</div>

<div class="container">
    <form>
        <?= $form::textarea('message', 'Qu\'avez-vous sur le coeur ?'); ?>

        <div class="settings">
            <?= $form::input('input', 'firstname', 'Prénom'); ?>
            <?= $form::input('input', 'lastname', 'Nom'); ?>
            <?= $form::input('email', 'email', 'Adresse mail'); ?>
            <?= $form::select('topic', 'Motif de contact', System::getSystemInfos('support')); ?>

            <div class="buttons">
                <?= $form::button('Envoyer mon message', 'contact-new', 'success'); ?>
            </div>
        </div>
    </form>
</div>