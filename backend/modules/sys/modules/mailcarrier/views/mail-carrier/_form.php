<?php
use backend\app\bootstrap\ActiveForm;
//
use backend\widgets\Forms\Tabs;

/**
 * @var $model \backend\modules\news\models\Group
 * @var $modelLang \backend\modules\news\models\GroupLang
 */
//
$form = ActiveForm::begin();
//
$items = [
    [
        'label' => Yii::t('app', 'General'),
        'content' => $this->render('parts/_settings', [
            'form' => $form,
            'model' => $model,
            'modelLang' => $modelLang
        ])
    ],
    [
        'label' => Yii::t('sys', 'MailCarrier: Extra'),
        'content' => $this->render('parts/_extra', [
            'form' => $form,
            'model' => $model,
            'modelLang' => $modelLang
        ])
    ],
];

echo $form->submit($model, $this)
    . Tabs::widget([
        'items' => $items
    ])
    . $form->submit($model, $this);
//
ActiveForm::end();
