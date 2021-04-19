<?php

namespace backend\modules\forms;

use Yii;

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
        $menuItems = [];

        if (in_array(Yii::$app->user->identity->group->role, ['admin', 'catalogEditor'])) {
            $menuItems = [
                'label' => 'Forms',
                'icon' => 'fa-tasks',
                'position' => 5,
                'items' => [
                    [
                        'label' => 'Feedback',
                        'icon' => 'fa-file-text',
                        'url' => ['/forms/forms-feedback/list'],
                    ],
                    [
                        'label' => 'Click on become partner',
                        'icon' => 'fa-file-text',
                        'url' => ['/forms/click-on-become-partner/list'],
                    ],
                ]
            ];
        }

        return $menuItems;
    }
}
