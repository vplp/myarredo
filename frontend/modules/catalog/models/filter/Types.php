<?php

namespace frontend\modules\catalog\models\filter;

use Yii;
use yii\data\ActiveDataProvider;
use yii\base\Model;
//
use frontend\modules\catalog\models\{
    Types as TypesModel
};

/**
 * Class Types
 *
 * @package frontend\modules\catalog\models\filter
 */
class Types extends TypesModel
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
    public function baseFilter($query, $params)
    {
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => false
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'alias', $this->alias]);

        $query->andFilterWhere(['like', TypesLang::tableName() . '.title', $this->title]);

        return $dataProvider;
    }

    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function filter($params)
    {
        $query = TypesModel::findBase();
        return $this->baseFilter($query, $params);
    }
}
