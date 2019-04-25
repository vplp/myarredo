<?php

use backend\widgets\Tabs;
use backend\app\bootstrap\ActiveForm;
use backend\modules\catalog\models\{
    Colors, ColorsLang
};

/**
 * @var $model Colors
 * @var $modelLang ColorsLang
 */

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
