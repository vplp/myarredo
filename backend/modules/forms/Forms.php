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
        'label' => 'Forms',
        'icon' => 'fa-tasks',
        'position' => 5,
        'items' => [
            [
                'label' => 'Callbacks',
                'icon' => 'fa-file-text',
                'url' => ['/forms/feedback/list'],
            ],
            [
                'label' => 'Questions',
                'icon' => 'fa-file-text',
                'url' => ['/forms/question/list'],
            ],
            [
                'label' => 'Repairment Orders',
                'icon' => 'fa-file-text',
                'url' => ['/forms/repairment/list'],
            ]
        ]
    ];
}