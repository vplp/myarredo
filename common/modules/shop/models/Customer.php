<?php

namespace common\modules\shop\models;

use common\modules\user\models\Profile;

/**
 * Class Customer
 *
 * @package common\modules\shop\models
 */
class Customer extends \thread\modules\shop\models\Customer
{
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfile()
    {
        return $this->hasOne(Profile::class, ['user_id' => 'user_id']);
    }
}