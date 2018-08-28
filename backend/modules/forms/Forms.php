<?php
namespace backend\modules\forms;

use common\modules\forms\Forms as FormsModule;

/**
 * Class Forms
 *
 * @package backend\modules\forms
 */
class Forms extends FormsModule
{
    /**
     * Number of elements in GridView
     * @var int
     */
    public $itemOnPage = 20;

    public $menuItems = [
        'name' => 'Forms',
        'icon' => 'fa-tasks',
        'position' => 5,
        'items' => [
            [
                'name' => 'Callbacks',
                'icon' => 'fa-file-text',
                'url' => ['/forms/feedback/list'],
            ],
            [
                'name' => 'Questions',
                'icon' => 'fa-file-text',
                'url' => ['/forms/question/list'],
            ],
            [
                'name' => 'Repairment Orders',
                'icon' => 'fa-file-text',
                'url' => ['/forms/repairment/list'],
            ]
        ]
    ];
}