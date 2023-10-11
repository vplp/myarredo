<?php

use backend\modules\news\models\{
    ArticleForPartners, ArticleForPartnersLang
};

/**
 * @var ArticleForPartners $model
 * @var ArticleForPartnersLang $modelLang
 */

$form->text_editor_lang($modelLang, 'content');