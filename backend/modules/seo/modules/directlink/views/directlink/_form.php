<?php

use backend\app\bootstrap\ActiveForm;
use backend\widgets\Tabs;

$form = ActiveForm::begin();

$items = [
    [
        'label' => Yii::t('app', 'Settings'),
        'content' => $this->render('parts/_settings', [
            'form' => $form,
            'model' => $model,
            'modelLang' => $modelLang
        ])
    ],
    [
        'label' => Yii::t('app', 'Content'),
        'content' => $this->render('parts/_content', [
            'form' => $form,
            'model' => $model,
            'modelLang' => $modelLang
        ])
    ],
    [
        'label' => Yii::t('app', 'Cities'),
        'content' => $this->render('parts/_cities', [
            'form' => $form,
            'model' => $model,
            'modelLang' => $modelLang
        ])
    ]
]; ?>

<?= $form->submit($model, $this) ?>

<?= Tabs::widget([
    'items' => $items
]); ?>

<?= $form->submit($model, $this) ?>

<?php ActiveForm::end();
