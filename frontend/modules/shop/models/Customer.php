<?php

namespace frontend\modules\shop\models;

use Yii;

use common\modules\shop\models\Customer as CommonCustomerModel;

/**
 * Class Customer
 * @package frontend\modules\shop\models
 * @author FilamentV <vortex.filament@gmail.com>
 * @author Alla Kuzmenko
 * @copyright (c) 2016, VipDesign
 */
class Customer extends CommonCustomerModel
{
    /**
     *
     * @return array
     */
    public function scenarios()
    {
        return [
            'addnewcustorem' => ['email', 'phone', 'full_name', 'user_id'],
        ];
    }

    
}