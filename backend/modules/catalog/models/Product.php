<?php

namespace backend\modules\catalog\models;

use yii\helpers\ArrayHelper;
use backend\modules\user\models\User;
use thread\app\model\interfaces\BaseBackendModel;
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
     * Backend form drop down list
     * @return array
     */
    public static function dropDownListEditor()
    {
        $query = self::find()
            ->indexBy('editor_id')
            ->select('editor_id, count(editor_id) as count')
            ->groupBy('editor_id')
            ->andWhere('editor_id > 0')
            ->asArray()
            ->all();

        $ids = [];

        foreach ($query as $item) {
            $ids[] = $item['editor_id'];
        }

        if ($ids) {
            return ArrayHelper::map(
                User::findBase()->andWhere(['IN', User::tableName() . '.id', $ids])->all(),
                'id',
                'profile.fullName'
            );
        } else {
            return [];
        }
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
    public function searchWithoutPriceList($params)
    {
        return (new search\Product())->searchWithoutPriceList($params);
    }

    /**
     * @param $params
     * @return \yii\data\ActiveDataProvider
     */
    public function searchWithoutPrices($params)
    {
        return (new search\Product())->searchWithoutPrices($params);
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
     * @param $params
     * @return \yii\data\ActiveDataProvider
     */
    public function searchTranslation($params)
    {
        return (new search\Product())->searchTranslation($params);
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
