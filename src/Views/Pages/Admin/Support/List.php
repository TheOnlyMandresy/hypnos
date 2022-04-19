<?php for ($i = 0; $i < count($topics); $i++): ?>
    <h2 class="section"><?= $topics[$i]; ?></h2>

    <div class="list">
    <?php
        foreach ($datas as $data):
        if (intval($data->topic) === $i):
    ?>
    
    <div class="box">
        <h3><?= $data->title; ?></h3>
        <p><?= $data->dateCreate; ?></p>

        <div class="buttons">
            <button class="btn-success">
                <span><a onclick="route()" href="<?= System::getSystemInfos('url_support'); ?>/<?= $data->id; ?>">voir</a></span>
            </button>
            
            <?php if (intval($data->state) !== 1): ?>
            <button class="btn-success2">
                <span><a name="close" data-infos="<?= $data->id; ?>">ou fermer</a></span>
            </button>
            <?php endif; ?>
        </div>
    </div>

    <?php
        endif; 
        endforeach;
    ?>
    </div>
<?php endfor; ?>