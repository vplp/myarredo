<?php

use yii\helpers\Html;

/**
 * @var \common\modules\forms\models\FormsFeedback $model
 */

?>

<?= Html::a(
    Yii::t('app', 'Связаться с оператором сайта'),
    'javascript:void(0);',
    [
        'class' => 'btn',
        'data-toggle' => 'modal',
        'data-target' => '#formFeedbackModal'
    ]
) ?>

<div class="modal fade" id="formFeedbackModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title"><?= Yii::t('app', 'Заполните форму') ?></h4>
            </div>
            <div class="modal-body">

                <?= $this->render('@app/modules/forms/views/forms/parts/form', [
                    'model' => $model
                ]) ?>

            </div>
        </div>
    </div>
</div>