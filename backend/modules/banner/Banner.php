<?php

namespace backend\modules\banner;

use Yii;

/**
 * Class Banner
 *
 * @package backend\modules\banner
 */
class Banner extends \common\modules\banner\Banner
{
    /**
     * Number of elements in GridView
     * @var int
     */
    public $itemOnPage = 20;

    public function getMenuItems()
    {
        $menuItems = [];

        if (in_array(Yii::$app->user->identity->group->role, ['admin'])) {
            $menuItems = [
                'label' => 'Banner',
                'icon' => 'fa-file-text',
                'url' => ['/banner/banner/list'],
                'position' => 4,
            ];
        }

        return $menuItems;
    }
}
