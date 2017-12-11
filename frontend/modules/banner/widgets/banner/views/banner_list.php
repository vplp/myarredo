<?php

?>

<?php if (!empty($items)): ?>
    <div id="general-slider_cnt" class="general-slider_cnt">
        <?php foreach ($items as $item): ?>
            <?= $this->render('_item', ['item' => $item]) ?>
        <?php endforeach; ?>
    </div>
<?php endif; ?>