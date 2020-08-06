<?php

namespace frontend\modules\shop;

use Yii;
use yii\db\ActiveRecord;

/**
 * Class Shop
 *
 * @package frontend\modules\shop
 */
class Shop extends \common\modules\shop\Shop
{
    /**
     * Number of elements in GridView
     * @var int
     */
    public $itemOnPage = 24;
}
