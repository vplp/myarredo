<?php

use backend\app\bootstrap\ActiveForm;
use backend\widgets\Tabs;

/**
 * @var $model \backend\modules\user\models\Profile
 */

?>

<?php $form = ActiveForm::begin(); ?>

<?= $form->submit($model, $this) ?>

<?= Tabs::widget([
    'items' => [
        [
            'label' => Yii::t('app', 'General'),
            'content' => $this->render('parts/_settings', [
                'form' => $form,
                'model' => $model,
            ])
        ],
        [
            'label' => Yii::t('app', 'Partner'),
            'content' => $this->render('parts/_partner_profile', [
                'form' => $form,
                'model' => $model,
            ]),
            'visible' => ($model->user->group_id == 4) ? 1 : 0
        ],
        [
            'label' => Yii::t('app', 'Factory'),
            'content' => $this->render('parts/_factory_profile', [
                'form' => $form,
                'model' => $model,
            ]),
            'visible' => ($model->user->group_id == 3) ? 1 : 0
        ],
        [
            'label' => Yii::t('app', 'Logistician'),
            'content' => $this->render('parts/_partner_profile', [
                'form' => $form,
                'model' => $model,
            ]),
            'visible' => ($model->user->group_id == 7) ? 1 : 0
        ],
    ]
]) ?>


<?= $form->submit($model, $this) ?>

<?php ActiveForm::end();
