<?php
    use System\Tools\FormTool;
    $form = new FormTool();
?>

<div class="title">
    <h1><?= $h1; ?></h1>
</div>

<div class="container">
    <form>
        <?= $form::input('input', 'firstname', 'Prénom'); ?>
        <?= $form::input('input', 'lastname', 'Nom'); ?>
        <?= $form::input('email', 'email', 'Adresse mail'); ?>
        <?= $form::input('password', 'password1', 'Mot de passe'); ?>
        <?= $form::input('password', 'password2', 'Mot de passe (vérification)'); ?>

        <div class="buttons">
            <?= $form::button('Valider', 'register', 'success'); ?>
        </div>
    </form>    
</div>