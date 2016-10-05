<?php
/**
 *
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */

?>
<li>
    <a href="<?= $model->getLink() ?>">
        <div>
            <i class="fa fa-envelope fa-fw"></i><?= $model['message'] ?>
            <span class="pull-right text-muted small"><?= $model->getDateTime() ?></span>
        </div>
    </a>
</li>
<li class="divider"></li>
