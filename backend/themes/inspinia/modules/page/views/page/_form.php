<?php
//
use thread\modules\seo\widgets\seo\SeoWidget;
//
use backend\modules\page\models\{
    Page, PageLang
};
//
use backend\themes\inspinia\widgets\{
    forms\ActiveForm, Tabs, forms\Form
};


/**
 * @var Page $model
 * @var PageLang $modelLang
 */
?>

<?php $form = ActiveForm::begin(); ?>

<?= Form::submit($model, $this) ?>

<?= Tabs::widget([
    'items' => [
        [
            'label' => Yii::t('app', 'Page'),
            'content' => $this->render('parts/_page', [
                'form' => $form,
                'model' => $model,
                'modelLang' => $modelLang,
            ])
        ],
        [
            'label' => Yii::t('app', 'Settings'),
            'content' => $this->render('parts/_settings', [
                'form' => $form,
                'model' => $model,
                'modelLang' => $modelLang,
            ])
        ],
        [
            'label' => Yii::t('app', 'SEO'),
            'content' => SeoWidget::widget(['nameSpaceModel' => Page::COMMON_NAMESPACE])
        ],
    ],
]); ?>

<?= Form::submit($model, $this) ?>

<?php ActiveForm::end(); ?>
