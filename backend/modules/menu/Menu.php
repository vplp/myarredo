<?php

namespace backend\modules\menu;
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

    public $menuItems = [
        'name' => 'Menu',
        'icon' => 'fa-tasks',
        'url' => ['/menu/menu/list'],
        'position' => 1,
    ];
}
