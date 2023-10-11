<?php

use backend\app\bootstrap\ActiveForm;
use backend\widgets\Tabs;

/**
 * @var \backend\app\bootstrap\ActiveForm $form
 * @var \backend\modules\catalog\models\FactoryPromotion $model
 */

?>

<?php $form = ActiveForm::begin(); ?>
<?= $form->submit($model, $this) ?>
<?= Tabs::widget([
    'items' => [
        [
            'label' => Yii::t('app', 'General'),
            'content' => $this->render('parts/_settings', [
                'form' => $form,
                'model' => $model
            ])
        ]
    ]
]) ?>
<?= $form->submit($model, $this) ?>
<?php ActiveForm::end(); ?>