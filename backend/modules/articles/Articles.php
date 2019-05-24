<?php

namespace backend\modules\articles;

use Yii;

/**
 * Class Articles
 *
 * @package backend\modules\articles
 */
class Articles extends \common\modules\articles\Articles
{
    /**
     * Number of elements in GridView
     * @var int
     */
    public $itemOnPage = 100;

    /**
     * @return array
     * @throws \Throwable
     */
    public function getMenuItems()
    {
        $menuItems = [];

        if (in_array(Yii::$app->user->identity->group->role, ['admin', 'catalogEditor', 'seo'])) {
            $menuItems = [
                'label' => Yii::t('app', 'Articles'),
                'icon' => 'fa-file-text',
                'position' => 2,
                'url' => ['/articles/article/list'],
            ];
        }
        return $menuItems;
    }
}
