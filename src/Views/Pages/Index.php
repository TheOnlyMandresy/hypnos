<?php ob_start(); ?>

<h1><?= $h1; ?></h1>

<div class="container">

    <?php for ($i = 0; $i < 7; $i++): ?>
    <div class="box">
        <div class="texts">
            <h2>Name of the hotel</h2>
            <h3>Place of the hotel</h3>
            <p>
                Lorem, ipsum dolor sit amet consectetur adipisicing elit. Quod corrupti sapiente quasi reprehenderit officia dolor est aliquid ab repellat dignissimos explicabo quaerat alias dolorum vero consequatur et, earum qui voluptate!
            </p>
        </div>

        <div class="buttons center">
            <button class="btn-success"><span>Voir les suites</span></button>
        </div>
    </div>
    <?php endfor; ?>
    
</div>

<?php $main = ob_get_clean(); ?>