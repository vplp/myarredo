<?php

namespace backend\modules\promotion;

use Yii;

/**
 * Class PromotionModule
 *
 * @package backend\modules\promotion
 */
class PromotionModule extends \common\modules\promotion\PromotionModule
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
                'label' => Yii::t('app', 'Promotion'),
                'icon' => 'fa-file-text',
                'position' => 4,
                'items' => [
                    [
                        'label' => Yii::t('app', 'Promotion package'),
                        'url' => ['/promotion/promotion-package/list'],
                        'position' => 4,
                    ]
                ]
            ];
        }

        return $menuItems;
    }
}
