<?php

use thread\modules\seo\widgets\seo\SeoWidget;
use thread\app\bootstrap\{
    ActiveForm, Tabs
};
//
use backend\modules\page\models\{
    Page, PageLang
};

/**
 * @var Page $model
 * @var PageLang $modelLang
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
            'label' => Yii::t('app', 'Page'),
            'content' => $this->render('parts/_page', [
                'form' => $form,
                'model' => $model,
                'modelLang' => $modelLang,
            ])
        ],
        [
            'label' => Yii::t('app', 'Seo'),
            'content' => SeoWidget::widget(['nameSpaceModel' => Page::COMMON_NAMESPACE])
        ],
    ],
]); ?>

<?= $form->submit($model, $this) ?>
<?php ActiveForm::end(); ?>
