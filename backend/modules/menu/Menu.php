<?php

namespace backend\modules\menu;

use Yii;

/**
 * Class Menu
 *
 * @package backend\modules\menu
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class Menu extends \common\modules\menu\Menu
{
    public $itemOnPage = 20;

    /**
     * Шлях до файлу конфігурації
     * @var string
     */
    public $configPath = __DIR__ . '/config.php';

    public function getMenuItems()
    {
        $menuItems = [];

        if (in_array(Yii::$app->user->identity->group->role, ['admin'])) {
            $menuItems = [
                'label' => 'Menu',
                'icon' => 'fa-sitemap',
                'url' => ['/menu/menu/list'],
                'position' => 2,
            ];
        }

        return $menuItems;
    }
}
