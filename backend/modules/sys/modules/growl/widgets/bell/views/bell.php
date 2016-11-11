<?php
/**
 *
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */

?>
<a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
    <i class="fa fa-bell"></i> <span class="label label-primary"><?= $counter ?></span>
</a>
<ul class="dropdown-menu dropdown-alerts">
    <?php foreach ($models as $model):
        echo $this->render('part/bell_item', ['model' => $model]);
    endforeach; ?>
    <li>
        <div class="text-center link-block">
            <a href="<?= $growlLink ?>">
                <strong><?= Yii::t('widget', 'See All Alerts') ?></strong>
                <i class="fa fa-angle-right"></i>
            </a>
        </div>
    </li>
</ul>

