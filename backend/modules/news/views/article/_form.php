<?php
use thread\modules\seo\widgets\seo\SeoWidget;
use thread\app\base\models\ActiveRecord;
//
use backend\modules\news\models\{
    Article, ArticleLang
};
use backend\themes\inspinia\widgets\{
    forms\ActiveForm, forms\Form, Tabs
};

/**
 * @var Article $model
 * @var ArticleLang|ActiveRecord $modelLang
 */
?>
<?php $form = ActiveForm::begin(); ?>
<?= Form::submit($model, $this); ?>
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
<?= Form::submit($model, $this) ?>
<?php ActiveForm::end();
