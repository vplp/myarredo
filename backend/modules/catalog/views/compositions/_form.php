<?php

use yii\helpers\{
    Html
};
use backend\widgets\Tabs;
use backend\app\bootstrap\ActiveForm;
use backend\modules\catalog\models\{
    Composition, CompositionLang
};

/**
 * @var $form ActiveForm
 * @var $model Composition
 * @var $modelLang CompositionLang
 */

?>

<?php $form = ActiveForm::begin(); ?>
<?= $form->submit($model, $this) ?>

<?= Html::activeHiddenInput($model, 'is_composition', ['value' => 1]) ?>

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
            'label' => Yii::t('page', 'Page'),
            'content' => $this->render('parts/_page', [
                'form' => $form,
                'model' => $model,
                'modelLang' => $modelLang,
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
        [
            'label' => 'Товары',
            'content' => $this->render('parts/_products', [
                'form' => $form,
                'model' => $model,
                'modelLang' => $modelLang
            ])
        ],
        [
            'label' => 'Стили',
            'content' => $this->render('parts/_specification', [
                'form' => $form,
                'model' => $model,
                'modelLang' => $modelLang
            ])
        ],
        [
            'label' => 'Редактор',
            'content' => $this->render('parts/_editors', [
                'model' => $model
            ])
        ],
    ]
]) ?>
<?= $form->submit($model, $this) ?>
<?php ActiveForm::end(); ?>
