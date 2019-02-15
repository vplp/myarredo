<?php

namespace backend\modules\news;

use Yii;

/**
 * Class News
 *
 * @package backend\modules\news
 */
class News extends \common\modules\news\News
{
    /**
     * @var int
     */
    public $itemOnPage = 20;

    public function getMenuItems()
    {
        $menuItems = [];

        if (in_array(Yii::$app->user->identity->group->role, ['admin', 'catalogEditor'])) {
            $menuItems = [
                'label' => 'Information for partners',
                'icon' => 'fa-file-text',
                'position' => 2,
                'url' => ['/news/article-for-partners/list'],
            ];
        }

        return $menuItems;
    }
}
