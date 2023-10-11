<?php

namespace frontend\modules\shop\models;

/**
 * Class Customer
 *
 * @package frontend\modules\shop\models
 */
class Customer extends \common\modules\shop\models\Customer
{
    /**
     * @return array
     */
    public function scenarios()
    {
        return [
            'addNewCustomer' => ['email', 'phone', 'full_name', 'user_id'],
        ];
    }
}