<?php

namespace frontend\modules\catalog\models\search;

use yii\data\ActiveDataProvider;
use yii\base\Model;
//
use frontend\modules\catalog\models\{
    Category as CategoryModel
};

/**
 * Class Category
 *
 * @package frontend\modules\catalog\models\search
 */
class Category extends CategoryModel
{
    public $title;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['alias', 'title'], 'string', 'max' => 255],
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
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => false
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'alias', $this->alias]);
        //
        $query->andFilterWhere(['like', CategoryLang::tableName() . '.title', $this->title]);

        return $dataProvider;
    }

    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = CategoryModel::findBase();
        return $this->baseSearch($query, $params);
    }
}
