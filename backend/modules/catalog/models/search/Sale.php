<?php

namespace backend\modules\catalog\models\search;

use Yii;
use yii\data\ActiveDataProvider;
use yii\base\Model;
//
use thread\app\model\interfaces\search\BaseBackendSearchModel;
//
use backend\modules\catalog\models\{
    SaleRelCategory, Sale as SaleModel, SaleLang
};

/**
 * Class Sale
 *
 * @package backend\modules\catalog\models\search
 */
class Sale extends SaleModel implements BaseBackendSearchModel
{
    public $title;
    public $category;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['category', 'factory_id'], 'integer'],
            [['alias', 'title'], 'string', 'max' => 255],
            [['published'], 'in', 'range' => array_keys(self::statusKeyRange())],
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
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'factory_id' => $this->factory_id
        ]);
        //
        $query->andFilterWhere(['like', 'alias', $this->alias])
            ->andFilterWhere(['like', 'published', $this->published]);
        //
        $query->andFilterWhere(['like', SaleLang::tableName() . '.title', $this->title]);
        //
        $query->innerJoinWith(["category"])->andFilterWhere([SaleRelCategory::tableName() . '.group_id' => $this->category]);

        return $dataProvider;
    }

    /**
     * @param $params
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = SaleModel::findBase()->undeleted();
        return $this->baseSearch($query, $params);
    }

    /**
     * @param $params
     * @return ActiveDataProvider
     */
    public function trash($params)
    {
        $query = SaleModel::findBase()->deleted();
        return $this->baseSearch($query, $params);
    }
}
