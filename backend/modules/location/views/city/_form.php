<?php

use backend\app\bootstrap\ActiveForm;
use backend\widgets\Tabs;
use yii\helpers\Url;
/**
 * @var $model \backend\modules\location\models\City
 * @var $modelLang \backend\modules\location\models\CityLang
 * @var $form \backend\widgets\forms\ActiveForm
 */

$this->context->actionListLinkStatus = Url::to(['/location/city/list',]);

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
                'modelLang' => $modelLang
            ])
        ],
        [
            'label' => 'Гео-(Мета) Тэги',
            'content' => $this->render('parts/_geo', [
                'form' => $form,
                'model' => $model,
                'modelLang' => $modelLang
            ])
        ],
    ]
]) ?>

<?= $form->submit($model, $this) ?>

<?php ActiveForm::end(); ?>