<?php

use backend\app\bootstrap\ActiveForm;
use backend\widgets\Tabs;
use backend\modules\articles\models\{
    Article, ArticleLang
};
/**
 * @var ActiveForm $form
 * @var Article $model
 * @var ArticleLang $modelLang
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
