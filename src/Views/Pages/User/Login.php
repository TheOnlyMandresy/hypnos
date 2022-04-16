<?php
    use System\Tools\FormTool;
    $form = new FormTool();
?>

<div class="title">
    <h1><?= $h1; ?></h1>
</div>

<div class="container">
    <form>
        <?= $form::input('email', 'email', 'Adresse mail'); ?>
        <?= $form::input('password', 'password', 'Mot de passe'); ?>

        <div class="buttons">
            <?= $form::button('connexion', 'login', 'success'); ?>
            <button class="btn-success2"><span><a onclick="route()" href="/register">ou inscription</a></span></button>
        </div>
    </form>    
</div>