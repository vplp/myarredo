<?php

namespace api\modules\shop\models;

use common\modules\shop\models\Order as ParentModel;

/**
 * Class Order
 *
 * @package api\modules\shop\models
 */
class Order extends ParentModel
{

    public static function getOrderStatusForApi()
    {
        return [
            self::status_new,
            self::status_work,
            self::agreed_by_manager,
            self::status_changed,
            self::status_send,
        ];
    }

}
