<?php
namespace backend\modules\news;

/**
 * Class News
 *
 * @package backend\modules\news
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class News extends \common\modules\news\News
{
    /**
     * Number of elements in GridView
     * @var int
     */
    public $itemOnPage = 20;

    public $menuItems = [
        'name' => 'News',
        'icon' => 'fa-file-text',
        'url' => ['/news/article/list'],
        'position' => 2,
    ];
}
