<?php

namespace backend\modules\news\models;

use yii\helpers\ArrayHelper;

/**
 * Class ArticleLang
 *
 * @package backend\modules\news\models
 */
class ArticleLang extends \common\modules\news\models\ArticleLang
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
