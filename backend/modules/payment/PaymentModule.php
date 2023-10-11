<?php

namespace backend\modules\payment;

use Yii;

/**
 * Class PaymentModule
 *
 * @package backend\modules\payment
 */
class PaymentModule extends \common\modules\payment\PaymentModule
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
                'label' => Yii::t('app', 'Payment'),
                'icon' => 'fa-file-text',
                'url' => ['/payment/payment/list'],
                'position' => 4,
            ];
        }

        return $menuItems;
    }
}
