<?php

namespace frontend\modules\shop\models;

use common\modules\shop\models\Cart as CommonCartModel;
use frontend\modules\shop\models\query\CartQuery;


/**
 * Class Cart
 * @package frontend\modules\shop\models
 * @author FilamentV <vortex.filament@gmail.com>
 * @author Alla Kuzmenko
 * @copyright (c) 2016, VipDesign
 */
class Cart extends CommonCartModel
{
    /**
     * @var
     */
    public static $commonQuery = CartQuery::class;
    
    /**
     *
     * @return  yii\db\ActiveQuery
     */
    public static function findBySessionID()
    {
        return self::find()->php_session_id(self::getSessionID())->enabled()->one();
    }

    /**
     * @return mixed
     */
    public function getItems()
    {
        return $this->hasMany(CartItem::class, ['cart_id' => 'id']);
    }


}