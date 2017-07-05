<?php

namespace backend\modules\menu\models;

use yii\helpers\ArrayHelper;

/**
 * Class MenuLang
 *
 * @package backend\modules\menu\models
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class MenuLang extends \common\modules\menu\models\MenuLang
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
