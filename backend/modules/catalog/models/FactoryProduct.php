<?php

namespace backend\modules\catalog\models;

use thread\app\model\interfaces\BaseBackendModel;
use common\modules\catalog\models\Product;
use backend\modules\user\models\Group as UserGroup;

/**
 * Class FactoryProduct
 *
 * @package backend\modules\catalog\models
 */
class FactoryProduct extends Product implements BaseBackendModel
{
    /**
     * @return mixed
     */
    public static function findBase()
    {
        return self::find()
            ->innerJoinWith(['lang', 'factory', 'userGroup'])
            // ->group->role == 'factory'
            //->andWhere(self::tableName() . '.user_id > 0')
            ->andWhere(UserGroup::tableName() . ".role = 'factory'")
            ->orderBy(self::tableName() . '.updated_at DESC');
    }

    /**
     * @param $params
     * @return \yii\data\ActiveDataProvider
     */
    public function search($params)
    {
        return (new search\FactoryProduct())->search($params);
    }

    /**
     * @param $params
     * @return \yii\data\ActiveDataProvider
     */
    public function trash($params)
    {
        return (new search\FactoryProduct())->trash($params);
    }
}
