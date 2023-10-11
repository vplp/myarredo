<?php

namespace frontend\modules\catalog\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
//
use thread\app\model\interfaces\search\BaseBackendSearchModel;
//
use frontend\modules\catalog\models\{
    FactoryProduct as FactoryProductModel,
    FactoryProductLang,
    ProductRelCategory
};
use frontend\modules\catalog\Catalog;

/**
 * Class FactoryProduct
 *
 * @property integer $category_id
 *
 * @package frontend\modules\catalog\models\search
 */
class FactoryProduct extends FactoryProductModel implements BaseBackendSearchModel
{
    public $title;
    public $category;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['id', 'category', 'factory_id'], 'integer'],
            [['article', 'title'], 'string', 'max' => 255],
            [['published', 'removed'], 'in', 'range' => array_keys(self::statusKeyRange())],
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

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => isset($params['pagination']) ? $params['pagination'] : [
                'defaultPageSize' => $module->itemOnPage,
                'forcePageParam' => false,
            ],
        ]);

        $query->andFilterWhere([
            'is_composition' => '0'
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'factory_id' => $this->factory_id,
        ]);

        $query->innerJoinWith(['lang']);

        $query
            ->andFilterWhere(['like', self::tableName() . '.published', $this->published])
            ->andFilterWhere(['like', FactoryProductLang::tableName() . '.title', $this->title])
            ->andFilterWhere(['like', FactoryProduct::tableName() . '.article', $this->article]);

        $query
            ->innerJoinWith(["category"])
            ->andFilterWhere([ProductRelCategory::tableName() . '.group_id' => $this->category]);

        self::getDb()->cache(function ($db) use ($dataProvider) {
            $dataProvider->prepare();
        }, 60 * 60 * 3, self::generateDependency(self::find()));

        return $dataProvider;
    }

    /**
     * @param $params
     * @return ActiveDataProvider
     * @throws \Throwable
     */
    public function search($params)
    {
        $query = FactoryProductModel::findBase()->undeleted();
        return $this->baseSearch($query, $params);
    }

    /**
     * @param $params
     * @return mixed|ActiveDataProvider
     * @throws \Throwable
     */
    public function trash($params)
    {
        $query = FactoryProductModel::findBase()->deleted();
        return $this->baseSearch($query, $params);
    }
}
