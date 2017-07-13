<?php

namespace backend\modules\menu\models;

use yii\helpers\ArrayHelper;

/**
 * Class MenuItemLang
 *
 * @package backend\modules\menu\models
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class MenuItemLang extends \common\modules\menu\models\MenuItemLang
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
