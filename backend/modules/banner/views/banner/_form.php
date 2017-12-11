<?php

use backend\app\bootstrap\ActiveForm;
use backend\themes\defaults\widgets\Tabs;

/**
 * @var \backend\modules\banner\models\BannerItem $model
 * @var \backend\modules\banner\models\BannerItemLang $modelLang
 * @var \backend\app\bootstrap\ActiveForm $form
 */

?>

<?php $form = ActiveForm::begin(); ?>
<?= $form->submit($model, $this) ?>
<?= Tabs::widget([
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
            'label' => Yii::t('app', 'Image'),
            'content' => $this->render('parts/_image', [
                'form' => $form,
                'model' => $model,
                'modelLang' => $modelLang
            ])
        ]
    ]
]) ?>
<?= $form->submit($model, $this) ?>
<?php ActiveForm::end(); ?>
