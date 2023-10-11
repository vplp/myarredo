<?php

use backend\modules\news\models\{
    ArticleForPartners, ArticleForPartnersLang
};

/**
 * @var ArticleForPartners $model
 * @var ArticleForPartnersLang $modelLang
 */

echo $form->field($model, 'image_link')->imageOne($model->getArticleImage());
