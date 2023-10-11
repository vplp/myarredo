<?php

use backend\app\bootstrap\{
    ActiveForm
};
use backend\widgets\Tabs;
//
use backend\modules\page\models\{
    Page, PageLang
};

/**
 * @var Page $model
 * @var PageLang $modelLang
 */
//
$form = ActiveForm::begin();
//
$items = [
    [
        'label' => Yii::t('app', 'Settings'),
        'content' => $this->render('parts/_settings', [
            'form' => $form,
            'model' => $model,
            'modelLang' => $modelLang,
        ])
    ],
    [
        'label' => Yii::t('page', 'Page'),
        'content' => $this->render('parts/_page', [
            'form' => $form,
            'model' => $model,
            'modelLang' => $modelLang,
        ])
    ]
];

if (!$model->isNewRecord) {
    $items[] = [
        'label' => Yii::t('seo', 'Seo'),
        'content' => $this->render('parts/_seo', [
            'form' => $form,
            'model' => $model,
            'modelLang' => $modelLang
        ]),
    ];
}

?>
<?= $form->submit($model, $this) ?>
<?= Tabs::widget([
    'items' => $items
]) ?>
<?= $form->submit($model, $this) ?>
<?php ActiveForm::end(); ?>
