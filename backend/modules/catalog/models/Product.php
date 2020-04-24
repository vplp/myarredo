<?php

namespace backend\modules\catalog\models;

use yii\helpers\ArrayHelper;

//
use thread\app\model\interfaces\BaseBackendModel;

//
use common\modules\catalog\models\Product as CommonProductModel;

/**
 * Class Product
 *
 * @package backend\modules\catalog\models
 */
class Product extends CommonProductModel implements BaseBackendModel
{
    public $parent_id = 0;

    /**
     * Backend form drop down list
     * @return array
     */
    public static function dropDownList()
    {
        return ArrayHelper::map(self::findBase()->undeleted()->all(), 'id', 'lang.title');
    }

    /**
     * @param $params
     * @return \yii\data\ActiveDataProvider
     */
    public function search($params)
    {
        return (new search\Product())->search($params);
    }

    /**
     * @param $params
     * @return \yii\data\ActiveDataProvider
     */
    public function trash($params)
    {
        return (new search\Product())->trash($params);
    }

    /**
     * @param $params
     * @return \yii\data\ActiveDataProvider
     */
    public function searchWithoutSpecificationAndDescription($params)
    {
        return (new search\Product())->searchWithoutSpecificationAndDescription($params);
    }

    /**
     * @inheritdoc
     */
    public function afterDelete()
    {
        // Update Product Count In to Group
        Category::updateEnabledProductCount($this->category_ids);
        Factory::updateEnabledProductCount($this->factory_id);

        parent::afterDelete();
    }
}
