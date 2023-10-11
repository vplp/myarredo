<?php

namespace backend\modules\catalog\models\search;

use Yii;
use yii\data\ActiveDataProvider;
use yii\base\Model;
use thread\app\model\interfaces\search\BaseBackendSearchModel;
use backend\modules\catalog\models\{
    ItalianProductRelCategory, ItalianProduct as ItalianProductModel, ItalianProductLang
};

/**
 * Class ItalianProduct
 *
 * @package backend\modules\catalog\models\search
 */
class ItalianProduct extends ItalianProductModel implements BaseBackendSearchModel
{
    public $title;
    public $category;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['category', 'factory_id', 'city_id', 'user_id'], 'integer'],
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
            self::tableName() . '.id' => $this->id,
            self::tableName() . '.factory_id' => $this->factory_id,
            self::tableName() . '.city_id' => $this->city_id,
            self::tableName() . '.user_id' => $this->user_id
        ]);

        $query
            ->andFilterWhere(['like', self::tableName() . '.alias', $this->alias])
            ->andFilterWhere(['=', self::tableName() . '.published', $this->published]);

        $query->andFilterWhere(['like', ItalianProductLang::tableName() . '.title', $this->title]);

        if ($this->category) {
            $query->innerJoinWith(["category"])
                ->andFilterWhere([ItalianProductRelCategory::tableName() . '.group_id' => $this->category]);
        }

        return $dataProvider;
    }

    /**
     * @param $params
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = ItalianProductModel::findBase()->undeleted();
        return $this->baseSearch($query, $params);
    }

    /**
     * @param $params
     * @return ActiveDataProvider
     */
    public function trash($params)
    {
        $query = ItalianProductModel::findBase()->deleted();
        return $this->baseSearch($query, $params);
    }
}
