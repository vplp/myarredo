<?php

namespace common\modules\shop\models;

use yii\helpers\ArrayHelper;

/**
 * Class Cart
 *
 * @package common\modules\shop\models
 */
class Cart extends \thread\modules\shop\models\Cart
{
    /**
     * @return array
     */
    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
            [['php_session_id'], 'string', 'max' => 180],
        ]);
    }

    /**
     * @return mixed
     */
    public function getItems()
    {
        return $this->hasMany(CartItem::class, ['cart_id' => 'id']);
    }
}
