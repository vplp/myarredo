<?php

namespace common\modules\shop;

use Yii;

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
    public function getShopBaseUploadPath($key = 'order')
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
    public function getShopBaseUploadUrl($key = 'order')
    {
        $item = [
            'order' => '/uploads/shop/order/',
        ];

        return $item[$key];
    }
}
