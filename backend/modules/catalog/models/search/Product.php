<?php

namespace backend\modules\catalog\models\search;

use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use yii\data\ActiveDataProvider;
use thread\app\model\interfaces\search\BaseBackendSearchModel;
use common\modules\catalog\models\ProductRelFactoryPricesFiles;
use backend\modules\catalog\Catalog;
use backend\modules\catalog\models\{
    ProductRelCategory, Product as ProductModel, ProductLang, Specification, ProductRelSpecification
};

/**
 * Class Product
 *
 * @package backend\modules\catalog\models\search
 */
class Product extends ProductModel implements BaseBackendSearchModel
{
    public $title;
    public $category;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['id', 'category', 'factory_id', 'editor_id'], 'integer'],
            [['alias', 'title', 'image_link'], 'string', 'max' => 255],
            [['published', 'removed', 'novelty'], 'in', 'range' => array_keys(self::statusKeyRange())],
        ];
    }

    /**
     *
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
     */
    public function baseSearch($query, $params)
    {
        /** @var Catalog $module */
        $module = Yii::$app->getModule('catalog');
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'defaultPageSize' => $module->itemOnPage
            ],
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC
                ]
            ]
        ]);

        $query->andFilterWhere([
            Product::tableName() . '.is_composition' => '0'
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            self::tableName() . '.id' => $this->id,
            self::tableName() . '.factory_id' => $this->factory_id,
            self::tableName() . '.editor_id' => $this->editor_id,
        ]);

        $query
            ->andFilterWhere(['like', self::tableName() . '.alias', $this->alias])
            ->andFilterWhere(['=', self::tableName() . '.published', $this->published])
            ->andFilterWhere(['=', self::tableName() . '.novelty', $this->novelty])
            ->andFilterWhere(['=', self::tableName() . '.removed', $this->removed]);

        $query
            ->andFilterWhere(['like', ProductLang::tableName() . '.title', $this->title]);

        if ($this->category) {
            $query
                ->innerJoinWith(["category"])
                ->andFilterWhere([ProductRelCategory::tableName() . '.group_id' => $this->category]);
        }

        return $dataProvider;
    }

    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = ProductModel::findBase()->undeleted();
        return $this->baseSearch($query, $params);
    }

    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function trash($params)
    {
        $query = ProductModel::findBase()->deleted();
        return $this->baseSearch($query, $params);
    }

    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function searchWithoutSpecificationAndDescription($params)
    {
        $query = ProductModel::findBase()->undeleted();

        // не светильники
        $query
            ->innerJoinWith(["category"])
            ->andFilterWhere([
                'NOT IN',
                Category::tableName() . '.id',
                14
            ]);

        $data = Specification::find()->andWhere(['parent_id' => 4])->all();
        $modelSpecification = ArrayHelper::map($data, 'id', 'id');

        // меньше 2-х размеров
        $subQuery1 = ProductRelSpecification::find()
            ->select('catalog_item_id')
            ->andWhere([
                'IN',
                ProductRelSpecification::tableName() . '.specification_id',
                $modelSpecification
            ])
            ->groupBy(ProductRelSpecification::tableName() . '.catalog_item_id')
            ->having(
                'count(' . ProductRelSpecification::tableName() . '.catalog_item_id) < 2'
            );

        // нет размеров
        $subQuery2 = ProductRelSpecification::find()
            ->select('catalog_item_id')
            ->andWhere([
                'NOT IN',
                ProductRelSpecification::tableName() . '.specification_id',
                $modelSpecification
            ])
            ->groupBy(ProductRelSpecification::tableName() . '.catalog_item_id');

        $query
            ->andWhere([
                'OR',
                ['=', ProductLang::tableName() . '.description', ''],
                ['in', self::tableName() . '.id', $subQuery1],
                //['in', self::tableName() . '.id', $subQuery2]
            ]);

        return $this->baseSearch($query, $params);
    }

    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function searchTranslation($params)
    {
        $query = ProductModel::findBase()->undeleted();

        $query
            ->andWhere([
                'OR',
                ['=', ProductLang::tableName() . '.mark', '0'],
                //['=', ProductLang::tableName() . '.title', ''],
                //['=', ProductLang::tableName() . '.description', '']
            ]);

        return $this->baseSearch($query, $params);
    }

    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function searchWithoutPriceList($params)
    {
        $query = ProductModel::findBase()
            ->andFilterWhere([
                ProductModel::tableName() . '.removed' => '0'
            ])
            ->enabled();

        $query
            ->joinWith(["factoryPricesFiles" => function ($query) {
                return $query
                    ->andWhere(['IS', ProductRelFactoryPricesFiles::tableName() . '.catalog_item_id', null]);
            }]);

        return $this->baseSearch($query, $params);
    }

    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function searchWithoutPrices($params)
    {
        $query = ProductModel::findBase()
            ->andFilterWhere([
                ProductModel::tableName() . '.removed' => '0'
            ])
            ->andWhere([
                'OR',
                ['=', ProductModel::tableName() . '.factory_price', '0'],
                ['=', ProductModel::tableName() . '.price_from', '0'],
            ])
            ->enabled();

        return $this->baseSearch($query, $params);
    }
}
