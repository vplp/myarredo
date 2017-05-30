<?php
namespace backend\modules\page;

/**
 * Class Page
 *
 * @package backend\modules\page
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class Page extends \common\modules\page\Page
{
    public $itemOnPage = 20;

    public $menuItems = [
        'name' => 'Pages',
        'icon' => 'fa-file-text',
        'url' => ['/page/page/list'],
        'position' => 2,
    ];
}
