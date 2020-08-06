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
     * Product upload path
     * @return string
     */
    public function getOrderUploadPath()
    {
        $dir = $this->getBaseUploadPath() . '/shop/order';

        return $dir;
    }

    /**
     * Product upload URL
     * @return string
     */
    public function getOrderUploadUrl()
    {
        return $this->getBaseUploadUrl() . '/shop/order';
    }

    /**
     * Image upload path
     * @return string
     */
    public function getBaseUploadPath()
    {
        return Yii::getAlias('@uploads');
    }

    /**
     * Base upload URL
     * @return string
     */
    public function getBaseUploadUrl()
    {
        return '/uploads';
    }
}
