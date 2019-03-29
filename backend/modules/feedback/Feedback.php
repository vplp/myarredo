<?php

namespace backend\modules\feedback;

/**
 * Class Feedback
 *
 * @package backend\modules\feedback
 */
class Feedback extends \common\modules\feedback\Feedback
{
    /**
     * Number of elements in GridView
     * @var int
     */
    public $itemOnPage = 20;

    public $menuItems = [
        'label' => 'Feedback',
        'icon' => 'fa-file-text',
        'position' => 4,
        'items' =>
            [
                [
                    'label' => 'Feedback',
                    'position' => 1,
                    'url' => ['/feedback/group/list'],
                ],
                [
                    'label' => 'Question',
                    'position' => 2,
                    'url' => ['/feedback/question/list'],
                ]
            ]
    ];
}
