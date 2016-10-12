<?php

use thread\app\bootstrap\ActiveForm;
//
use backend\themes\inspinia\widgets\Tabs;

/**
 * @var \backend\modules\catalog\models\GroupLang $modelLang
 * @var \backend\modules\catalog\models\Group $model
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
                'modelLang' => $modelLang,
            ])
        ],
        [
            'label' => Yii::t('app', 'Group'),
            'content' => $this->render('parts/_group', [
                'form' => $form,
                'model' => $model,
                'modelLang' => $modelLang,
            ])
        ],
        [
            'label' => Yii::t('app', 'Description'),
            'content' => $this->render('parts/_description', [
                'form' => $form,
                'model' => $model,
                'modelLang' => $modelLang,
            ])
        ],
        [
            'label' => Yii::t('app', 'Specifications'),
            'content' => $this->render('parts/_specifications', [
                'form' => $form,
                'model' => $model,
                'modelLang' => $modelLang,
            ])
        ]
    ],
]); ?>

<?= $form->submit($model, $this) ?>
<?php ActiveForm::end(); ?>