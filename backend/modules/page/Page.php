<?php

namespace backend\modules\page;

use Yii;

/**
 * Class Page
 *
 * @package backend\modules\page
 */
class Page extends \common\modules\page\Page
{
    public $itemOnPage = 20;

    public function getMenuItems()
    {
        $menuItems = [];

        if (in_array(Yii::$app->user->identity->group->role, ['admin', 'seo'])) {
            $menuItems = [
                'label' => 'Pages',
                'icon' => 'fa-sitemap',
                'url' => ['/page/page/list'],
                'position' => 1,
            ];
        }

        return $menuItems;
    }
}
