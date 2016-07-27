<?php
use thread\modules\seo\widgets\seo\SeoWidget;
use thread\app\base\models\ActiveRecord;
//
use backend\modules\news\models\{Article, ArticleLang};
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
            'label' => Yii::t('app', 'General information'),
            'content' => $this->render('formParts/_main', [
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
