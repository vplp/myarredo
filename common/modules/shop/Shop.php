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
     * @return string
     */
    public function getOrderUploadPath()
    {
        return $this->getShopBaseUploadPath('order');
    }

    /**
     * @return string
     */
    public function getOrderUploadUrl()
    {
        return $this->getShopBaseUploadUrl('order');
    }

    /**
     * @param $key
     * @return string
     */
    public function getShopBaseUploadPath($key)
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
     * @return string
     */
    public function getShopBaseUploadUrl($key)
    {
        $item = [
            'order' => '/uploads/shop/order/',
        ];

        return $item[$key];
    }
}
