<?php

use thread\app\bootstrap\{
    ActiveForm
};
use backend\themes\defaults\widgets\Tabs;

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
            'label' => Yii::t('app', 'Category'),
            'content' => $this->render('parts/_category', [
                'form' => $form,
                'model' => $model,
                'modelLang' => $modelLang
            ])
        ],
    ]
]) ?>
<?= $form->submit($model, $this) ?>
<?php ActiveForm::end(); ?>