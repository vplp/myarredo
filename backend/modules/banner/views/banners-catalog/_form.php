<?php

use backend\widgets\Tabs;
use backend\app\bootstrap\ActiveForm;
use backend\modules\banner\models\{
    BannerItemCatalog, BannerItemLang
};

/**
 * @var $model BannerItemCatalog
 * @var $modelLang BannerItemLang
 * @var $form ActiveForm
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
