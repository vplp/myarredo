<?php

use yii\helpers\Html;

//
use frontend\modules\forms\models\FormsFeedback;

/**
 * @var FormsFeedback $model
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
                <h4 class="modal-title"><?= Yii::t('app', 'Связаться с оператором сайта') ?></h4>
            </div>
            <div class="modal-body">

                <h4><?= Yii::t('app', 'Contacts') ?></h4>

                <?php
                if (Yii::$app->city->domain == 'com') {
                    $phone = '+39 (0422) 150-02-15';
                } elseif (Yii::$app->city->domain == 'ua') {
                    $phone = '+39 (0422) 150-02-15';
                } else {
                    $phone = '+7 968 353 36 36';
                }
                $email = (Yii::$app->city->domain == 'ua') ? 'help@myarredo.ua' : 'help@myarredo.ru';
                ?>

                <p><?= $phone ?></p>
                <p><?= $email ?></p>
                <p>skype: <?= Html::a('daniellalazareva123', 'skype:daniellalazareva123?chat') ?></p>

                <h4><?= Yii::t('app', 'Заполните форму') ?></h4>
                <?= $this->render('@app/modules/forms/views/forms/parts/form', [
                    'model' => $model
                ]) ?>

            </div>
        </div>
    </div>
</div>
