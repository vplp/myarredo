<?php

/**
 * @var \frontend\modules\banner\models\BannerItem $model
 */

?>

<?php if (!empty($items)): ?>
    <div id="general-slider_cnt" class="general-slider_cnt">
        <?php foreach ($items as $item): ?>
            <div class="general-slider_i">
                <?php if ($item->lang->link): ?>
                    <?= Html::a(Html::img($item->getBannerImage()), $item->lang->link) ?>
                <?php else: ?>
                    <?= Html::img($item->getBannerImage()) ?>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>