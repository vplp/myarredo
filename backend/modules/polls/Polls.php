<?php
namespace backend\modules\polls;

/**
 * Class News
 *
 * @package backend\modules\polls
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class Polls extends \common\modules\polls\Polls
{
    /**
     * Number of elements in GridView
     * @var int
     */
    public $itemOnPage = 20;

    public $menuItems = [
        'label' => 'Polls',
        'icon' => 'fa-users',
        'url' => ['/polls/polls/list'],
        'position' => 6,
    ];
}
