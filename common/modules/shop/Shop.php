<?php

namespace common\modules\shop;

use yii\db\ActiveRecord;

/**
 * Class Shop
 *
 * @package common\modules\shop
 */
class Shop extends \thread\modules\shop\Shop
{
    /**
     * @param ActiveRecord $model
     * @return string
     */
    public function getOrderUploadPath($model)
    {
        return $this->getShopBaseUploadPath('order', $model);
    }

    /**
     * @param ActiveRecord $model
     * @return string
     */
    public function getOrderUploadUrl($model)
    {
        return $this->getShopBaseUploadUrl('order', $model);
    }

    /**
     * @param $key
     * @param ActiveRecord $model
     * @return string
     */
    public function getShopBaseUploadPath($key, $model)
    {
        $item = [
            'order' => Yii::getAlias('@uploads') . '/shop/order/',
        ];

        $dir = $item[$key];

        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }

        return $dir;
    }

    /**
     * @param $key
     * @param ActiveRecord $model
     * @return string
     */
    public function getShopBaseUploadUrl($key, $model)
    {
        $item = [
            'order' => '/uploads/shop/order/',
        ];

        return $item[$key];
    }
}
