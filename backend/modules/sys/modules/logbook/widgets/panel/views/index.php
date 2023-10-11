<?php
/**
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 *
 * @var $models \backend\modules\sys\modules\logbook\models\Logbook[]
 * @var $model \backend\modules\sys\modules\logbook\models\Logbook
 */

use yii\helpers\Html;

$colors = [
    'recent-activity-warning',
    'recent-activity-primary',
    'recent-activity-success',
    'recent-activity-danger',
    'recent-activity-lilac',
    'recent-activity-warning',
    'recent-activity-primary',
    'recent-activity-success',
    'recent-activity-danger',
    'recent-activity-lilac',
];
?>
<div class="panel rounded shadow">
    <div class="panel-body">
        <div class="row">
            <div class="col-md-12">
                <?= Html::tag('h4', Yii::t('sys', 'Logbook')) ?>
            </div>
        </div>
        <div class="row">
            <?php
            foreach ($models as $k => $model) {
                ?>
                <!-- Start recent activity item -->
                <div class="recent-activity-item <?= $colors[$k] ?>">
                    <div class="recent-activity-badge">
                        <span class="recent-activity-badge-userpic"></span>
                    </div>
                    <div class="recent-activity-body">
                        <div class="recent-activity-body-head">
                            <div class="recent-activity-body-head-caption">
                                <h5 class="recent-activity-body-title">
                                    <?= $model['category'] ?>
                                </h5>
                            </div>
                        </div>
                        <div class="recent-activity-body-content">
                            <p>
                                <?= Html::a($model['message'], $model['url']) ?>
                                <span class="text-block text-muted">
                                    <?= $model->getModifiedTimeISO() ?>
                                </span>
                                <?= $model['user']['username'] ?>
                            </p>
                        </div>
                    </div>
                </div>
                <!-- End recent activity item -->
                <?php
            }
            ?>
        </div>
    </div>
</div>
