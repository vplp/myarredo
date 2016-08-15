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
            'label' => Yii::t('app', 'General'),
            'content' => $this->render('parts/_main', [
                'form' => $form,
                'model' => $model,
                'modelLang' => $modelLang
            ])
        ],
        [
            'label' => Yii::t('app', 'Page'),
            'content' => $this->render('parts/_content', [
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
            'label' => Yii::t('app', 'SEO'),
            'content' => SeoWidget::widget(['nameSpaceModel' => Article::COMMON_NAMESPACE])
        ]
    ]
]) ?>
<?= Form::submit($model, $this) ?>
<?php ActiveForm::end();
