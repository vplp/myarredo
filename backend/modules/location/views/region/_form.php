<?php

use yii\helpers\Url;
//
use backend\widgets\Tabs;
use backend\app\bootstrap\ActiveForm;

/**
 * @var $model \backend\modules\location\models\Region
 * @var $modelLang \backend\modules\location\models\RegionLang
 * @var $form \backend\widgets\forms\ActiveForm
 */

$this->context->actionListLinkStatus = Url::to(['/location/region/list',]);

$form = ActiveForm::begin();

echo $form->submit($model, $this);

echo Tabs::widget([
    'items' => [
        [
            'label' => Yii::t('app', 'General'),
            'content' => $this->render('parts/_settings', [
                'form' => $form,
                'model' => $model,
                'modelLang' => $modelLang
            ])
        ],
    ]
]);

echo $form->submit($model, $this);

ActiveForm::end();