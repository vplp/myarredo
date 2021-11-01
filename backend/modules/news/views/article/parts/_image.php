<?php

use backend\app\bootstrap\ActiveForm;
use backend\modules\news\models\{
    Article, ArticleLang
};

/**
 * @var $form ActiveForm
 * @var $model Article
 * @var $modelLang ArticleLang
 */

echo $form->field($model, 'image_link')->imageOne($model->getArticleImage());

echo $form->field($model, 'gallery_image')->imageSeveral(['initialPreview' => $model->getGalleryImage()]);
