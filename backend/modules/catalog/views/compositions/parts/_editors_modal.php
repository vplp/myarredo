<?php

use yii\grid\GridView;
use backend\modules\sys\modules\logbook\models\Logbook;
use backend\modules\catalog\models\Composition;

/**
 * @var $model Composition
 */

?>

<a data-toggle="modal" data-target="#editorComposition<?=$model->id ?>">
  <?= $model->editor->profile->fullName ?>
</a>

<div class="modal fade" id="editorComposition<?=$model->id ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Редакторы</h4>
            </div>
            <div class="modal-body">
                <?= GridView::widget([
                    'dataProvider' => (new Logbook())->search(['Logbook' => ['model_id' => $model->id, 'model_name' => 'Composition']]),
                    'columns' => [
                        [
                            //'attribute' => 'created_at',
                            'value' => function ($model) {
                                /** @var $model Logbook */
                                return $model->getModifiedTimeISO();
                            }
                        ],
                        [
                            'attribute' => 'user_id',
                            'value' => 'user.profile.fullName',
                        ]
                    ]
                ]); ?>
            </div>
        </div>
    </div>
</div>
