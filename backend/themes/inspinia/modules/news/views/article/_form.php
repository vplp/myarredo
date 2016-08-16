<?php
use thread\modules\seo\widgets\seo\SeoWidget;
use thread\app\bootstrap\{
    ActiveForm
};
//
use backend\themes\inspinia\widgets\Tabs;
//
use backend\modules\news\models\{
    Article, ArticleLang
};

/**
 * @var Article $model
 * @var ArticleLang $modelLang
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
            'label' => Yii::t('app', 'Page'),
            'content' => $this->render('parts/_page', [
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
        ],
        [
            'label' => Yii::t('app', 'Seo'),
            'content' => SeoWidget::widget(['nameSpaceModel' => Article::COMMON_NAMESPACE])
        ]
    ]
]) ?>
<?= $form->submit($model, $this) ?>
<?php ActiveForm::end(); ?>
