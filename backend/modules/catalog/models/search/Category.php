<?php

namespace backend\modules\catalog\models\search;

use yii\data\ActiveDataProvider;
use yii\base\Model;
//
use thread\app\model\interfaces\search\BaseBackendSearchModel;
//
use backend\modules\catalog\models\{
    Category as CategoryModel, CategoryLang
};

/**
 * Class Category
 *
 * @package backend\modules\catalog\models\search
 */
class Category extends CategoryModel implements BaseBackendSearchModel
{
    public $title;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['alias', 'title'], 'string', 'max' => 255],
            [['published'], 'in', 'range' => array_keys(self::statusKeyRange())],
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

        $query
            ->andFilterWhere(['like', self::tableName() . '.alias', $this->alias])
            ->andFilterWhere(['=', self::tableName() . '.published', $this->published]);

        $query->andFilterWhere(['like', CategoryLang::tableName() . '.title', $this->title]);

        return $dataProvider;
    }

    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = CategoryModel::findBase()->undeleted();
        return $this->baseSearch($query, $params);
    }

    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function trash($params)
    {
        $query = CategoryModel::findBase()->deleted();
        return $this->baseSearch($query, $params);
    }
}
