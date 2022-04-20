<?php
    use System\Database\Tables\UsersTable as Users;
    use System\Tools\FormTool;
    use System\Tools\TextTool;
    $form = new FormTool();
?>

<div class="chat">
<?php if (!is_null($datas['messages'])): ?>
    <?php foreach ($datas['messages'] as $data): ?>
    <div class="box <?php if ($datas['infos']->userId !== Users::$myDatas->id) echo 'me'; ?>">
        <p class="name"><?= $data->firstname; ?> <?= $data->lastname; ?> - <?= $data->dateSend; ?></p>
        <p class="message"><?= TextTool::security($data->message, 'decode'); ?></p>
    </div>
    <?php endforeach; ?>
<?php endif; ?>

<div class="box">
    <p class="name"><?= $datas['infos']->firstname; ?> <?= $datas['infos']->lastname; ?> - <?= $datas['infos']->dateCreate; ?></p>
    <p class="message"><?= TextTool::security($datas['infos']->message, 'decode'); ?></p>
</div>
</div>

<form>
    <?= $form::textarea('message', 'Ajouter quelque chose'); ?>
    <?= $form::button('envoyer', 'add', 'success', $datas['infos']->id); ?>
</form>