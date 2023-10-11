<?php

namespace backend\modules\news\models;

use yii\helpers\ArrayHelper;

/**
 * Class ArticleForPartnersLang
 *
 * @package backend\modules\news\models
 */
class ArticleForPartnersLang extends \common\modules\news\models\ArticleForPartnersLang
{
    /**
     * @return array
     */
    public function scenarios()
    {
        return ArrayHelper::merge(parent::scenarios(), [
            'title' => ['title'],
        ]);
    }
}
