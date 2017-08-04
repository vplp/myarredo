<?php

use yii\helpers\{
    Html
};
use thread\app\bootstrap\{
    ActiveForm
};
use backend\themes\defaults\widgets\Tabs;

?>

<?php $form = ActiveForm::begin(); ?>
<?= $form->submit($model, $this) ?>

<?= Html::activeHiddenInput($model, 'is_composition', ['value' => 0]) ?>

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
            'label' => 'Характеристики',
            'content' => $this->render('parts/_specification', [
                'form' => $form,
                'model' => $model,
                'modelLang' => $modelLang
            ])
        ],
        [
            'label' => 'Отделка',
            'content' => $this->render('parts/_samples', [
                'form' => $form,
                'model' => $model,
                'modelLang' => $modelLang
            ])
        ],
        [
            'label' => 'Прайсы и каталоги',
            'content' => $this->render('parts/_files', [
                'form' => $form,
                'model' => $model,
                'modelLang' => $modelLang
            ])
        ],
        [
            'label' => 'Популярный у партнеров',
            'content' => $this->render('parts/_popular', [
                'form' => $form,
                'model' => $model,
                'modelLang' => $modelLang
            ])
        ],
        [
            'label' => 'Альтернатива',
            'content' => $this->render('parts/_alternative', [
                'form' => $form,
                'model' => $model,
                'modelLang' => $modelLang
            ])
        ],
    ]
]) ?>
<?= $form->submit($model, $this) ?>
<?php ActiveForm::end(); ?>