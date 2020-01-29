<?php

namespace backend\modules\forms;

/**
 * Class FormsModule
 *
 * @package backend\modules\forms
 */
class FormsModule extends \common\modules\forms\FormsModule
{
    /**
     * Number of elements in GridView
     * @var int
     */
    public $itemOnPage = 20;

    public function getMenuItems()
    {
        return [
            'label' => 'Forms',
            'icon' => 'fa-tasks',
            'position' => 5,
            'items' => [
                [
                    'label' => 'Feedback',
                    'icon' => 'fa-file-text',
                    'url' => ['/forms/forms-feedback/list'],
                ],
            ]
        ];
    }
}
