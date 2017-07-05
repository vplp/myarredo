<?php

namespace backend\modules\feedback;

/**
 * Class Feedback
 *
 * @package backend\modules\feedback
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class Feedback extends \common\modules\feedback\Feedback
{
    /**
     * Number of elements in GridView
     * @var int
     */
    public $itemOnPage = 20;

    public $menuItems = [
        'name' => 'Feedback',
        'icon' => 'fa-file-text',
        'position' => 4,
        'items' =>
            [
                [
                    'name' => 'Feedback',
                    'position' => 1,
                    'url' => ['/feedback/group/list'],
                ],
                [
                    'name' => 'Question',
                    'position' => 2,
                    'url' => ['/feedback/question/list'],
                ]
            ]
    ];
}
