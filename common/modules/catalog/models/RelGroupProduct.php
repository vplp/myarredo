<?php

namespace common\modules\catalog\models;

/**
 * Class Group
 *
 * @package common\modules\catalog\models
 * @author Andrii Bondarchuk
 * @copyright (c) 2016, VipDesign
 */
class RelGroupProduct extends \thread\modules\catalog\models\RelGroupProduct
{
    /**
     * @param $productCardId
     * @param $categoryId
     * @return mixed
     */
    public static function finModelByRelation($groupId, $productId)
    {
        return self::findBase()
            ->andWhere(['product_id' => $productId, 'group_id' => $groupId])
            ->one();
    }


    /**
     * @return bool
     */

    public function beforeSave($insert)
    {
        $this->published = 1;
        return parent::beforeSave($insert);
    }
}