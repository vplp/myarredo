<?php

namespace frontend\modules\catalog\models\search;

use frontend\modules\location\models\Country;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\modules\catalog\models\{
    Category,
    Types,
    SubTypes,
    Factory,
    Product,
    ProductJson as ProductModel,
    ProductLang,
    Specification,
    Colors,
    ProductRelSpecification
};
use frontend\modules\catalog\Catalog;

/**
 * Class ProductJson
 *
 * @property integer $category_id
 *
 * @package frontend\modules\catalog\models\search
 */
class ProductJson extends ProductModel
{
    /**
     * @return array
     */
    public function rules()
    {
        return [

        ];
    }

    /**
     * @return array
     */
    public function scenarios()
    {
        return Model::scenarios();
    }

    /**
     * @param $query
     * @param $params
     * @return ActiveDataProvider
     * @throws \Exception
     * @throws \Throwable
     */
    public function baseSearch($query, $params)
    {
        /** @var Catalog $module */
        $module = Yii::$app->getModule('catalog');

        $keys = Yii::$app->catalogFilter->keys;

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => isset($params['pagination']) ? $params['pagination'] : [
                'defaultPageSize' => !empty($params['defaultPageSize'])
                    ? $params['defaultPageSize']
                    : $module->itemOnPage,
                'forcePageParam' => false,
            ],
        ]);

        if (!($this->load($params, ''))) {
            return $dataProvider;
        }

        $dataProvider->prepare();

        return $dataProvider;
    }

    /**
     * @param $params
     * @return ActiveDataProvider
     * @throws \Throwable
     */
    public function search($params)
    {
        $query = ProductModel::findBase();

        return $this->baseSearch($query, $params);
    }
}
