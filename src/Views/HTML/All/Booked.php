<div class="container">

<?php
if ($datas):
foreach ($datas as $data):
?>

<div id="booked<?= $data->id; ?>" class="box">
    <h2><?= $data->title; ?></h2>
    <p class="address">Chez <?= $data->institutionName; ?> (<?= $data->address; ?>)</p>
    <p class="dates">Du <?= $data->dateStart; ?> au <?= $data->dateEnd; ?></p>
    
    <div class="buttons">
        <button class="btn-danger">
            <span><a name="del" data-infos="<?= $data->id; ?>">Annuler la réservation</a></span>
        </button>
    </div>
</div>

<?php
endforeach;
endif;
?>

</div>