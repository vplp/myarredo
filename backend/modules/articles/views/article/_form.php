<?php

use backend\app\bootstrap\ActiveForm;
use backend\widgets\Tabs;

/**
 * @var \backend\app\bootstrap\ActiveForm $form
 * @var \backend\modules\articles\models\Article $model
 * @var \backend\modules\articles\models\ArticleLang $modelLang
 */

$form = ActiveForm::begin();

echo $form->submit($model, $this);

echo Tabs::widget([
    'items' => [
        [
            'label' => Yii::t('app', 'Settings'),
            'content' => $this->render('parts/_settings', [
                'form' => $form,
                'model' => $model,
                'modelLang' => $modelLang
            ])
        ],
        [
            'label' => Yii::t('app', 'Page'),
            'content' => $this->render('parts/_page', [
                'form' => $form,
                'model' => $model,
                'modelLang' => $modelLang
            ])
        ],
        [
            'label' => Yii::t('app', 'Image'),
            'content' => $this->render('parts/_image', [
                'form' => $form,
                'model' => $model,
                'modelLang' => $modelLang
            ])
        ],
    ]
]);

echo $form->submit($model, $this);

ActiveForm::end();
