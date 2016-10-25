<?php

namespace frontend\modules\shop\models;

use common\modules\shop\models\Order as CommonOrderModel;
use yii\helpers\Url;

/**
 * Class Order
 * @package frontend\modules\shop\models
 * @author FilamentV <vortex.filament@gmail.com>
 * @author Alla Kuzmenko
 * @copyright (c) 2016, VipDesign
 */
class Order extends CommonOrderModel
{
    /**
     *
     * @return array
     */
    public function scenarios()
    {
        return [
            'addneworder' => [
                'delivery_method_id',
                'payment_method_id',
                'delivery_price',
                'order_status',
                'payd_status',
                'comment',
                'items_summ',
                'items_total_summ',
                'discount_percent',
                'discount_money',
                'discount_full',
                'total_summ',
                'customer_id',
                'items_count',
                'items_total_count',
                'token',
                'published',
                'deleted'],
        ];
    }
  


   
    public static function findBase()
    {
        return self::find()->innerJoinWith(['items'/*, 'cartGoods.item', 'cartGoods.item.lang'*/])->enabled();
    }


    /**
     * @return mixed
     */
    public function getItems()
    {
        return $this->hasMany(OrderItem::class, ['order_id' => 'id']);
    }

   
    public static function findById($id)
    {
        return self::findBase()->byId($id)->one();
    }

    
    public static function findByCustomerId($customer_id)
    {        
        return self::findBase()->andWhere(['customer_id'=>$customer_id])->all();
    }

    
    public static function findByLink($token)
    {
        return self::findBase()->andWhere(['token'=>$token])->one();
    }

    /**
     * Generates new token
     */
    public function getTokenLink()
    {
        return Url::toRoute(['/shop/order/link','token' => $this->token], true);
         
    }



}