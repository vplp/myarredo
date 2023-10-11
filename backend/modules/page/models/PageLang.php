<?php

namespace backend\modules\page\models;

use yii\helpers\ArrayHelper;

/**
 * Class PageLang
 *
 * @package backend\modules\page\models
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class PageLang extends \common\modules\page\models\PageLang
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
