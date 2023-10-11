<?php

namespace backend\modules\files;

use Yii;

/**
 * Class FilesModule
 *
 * @package backend\modules\files
 */
class FilesModule extends \common\modules\files\FilesModule
{
    /**
     * Number of elements in GridView
     * @var int
     */
    public $itemOnPage = 20;

    public function getMenuItems()
    {
        $menuItems = [];

        if (in_array(Yii::$app->user->identity->group->role, ['admin', 'catalogEditor'])) {
            $menuItems = [
                'label' => 'Файлы',
                'icon' => 'fa-tasks',
                'url' => ['/files/files/list'],
                'position' => 11,
            ];
        }

        return $menuItems;
    }
}
