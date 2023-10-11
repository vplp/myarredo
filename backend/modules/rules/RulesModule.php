<?php

namespace backend\modules\rules;

use Yii;

/**
 * Class RulesModule
 *
 * @package backend\modules\rules
 */
class RulesModule extends \common\modules\rules\RulesModule
{
    /**
     * @var int
     */
    public $itemOnPage = 24;

    public function getMenuItems()
    {
        $menuItems = [];

        if (in_array(Yii::$app->user->identity->group->role, ['admin'])) {
            $menuItems = [
                'label' => Yii::t('app', 'General rules'),
                'icon' => 'fa-file-text',
                'url' => ['/rules/rules/list'],
                'position' => 4,
            ];
        }

        return $menuItems;
    }
}
