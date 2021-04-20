<?php

use backend\widgets\Tabs;
use backend\app\bootstrap\ActiveForm;
use backend\modules\user\models\{
    Profile, ProfileLang
};

/** @var $model Profile */
/** @var $modelLang ProfileLang */

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
                'modelLang' => $modelLang,
            ])
        ],
        [
            'label' => Yii::t('app', 'Partner'),
            'content' => $this->render('parts/_partner_profile', [
                'form' => $form,
                'model' => $model,
                'modelLang' => $modelLang,
            ]),
            'visible' => ($model->user->group_id == 4) ? 1 : 0
        ],
        [
            'label' => Yii::t('app', 'Главное фото'),
            'content' => $this->render('parts/_partner_image_main', [
                'form' => $form,
                'model' => $model,
                'modelLang' => $modelLang,
            ]),
            'visible' => ($model->user->group_id == 4) ? 1 : 0
        ],
        [
            'label' => Yii::t('app', 'Фото салонов'),
            'content' => $this->render('parts/_partner_image_salon', [
                'form' => $form,
                'model' => $model,
                'modelLang' => $modelLang,
            ]),
            'visible' => ($model->user->group_id == 4) ? 1 : 0
        ],
        [
            'label' => Yii::t('app', 'Factory'),
            'content' => $this->render('parts/_factory_profile', [
                'form' => $form,
                'model' => $model,
                'modelLang' => $modelLang,
            ]),
            'visible' => ($model->user->group_id == 3) ? 1 : 0
        ],
        [
            'label' => Yii::t('app', 'Logistician'),
            'content' => $this->render('parts/_partner_profile', [
                'form' => $form,
                'model' => $model,
                'modelLang' => $modelLang,
            ]),
            'visible' => ($model->user->group_id == 7) ? 1 : 0
        ],
        [
            'label' => 'Расчетный центр',
            'content' => $this->render('parts/_settlement_center_profile', [
                'form' => $form,
                'model' => $model,
                'modelLang' => $modelLang,
            ]),
            'visible' => ($model->user->group_id == 8) ? 1 : 0
        ],
    ]
]) ?>

<?= $form->submit($model, $this) ?>

<?php ActiveForm::end();
