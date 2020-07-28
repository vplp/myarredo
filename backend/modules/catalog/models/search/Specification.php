<?php

namespace backend\modules\catalog\models\search;

use yii\data\ActiveDataProvider;
use yii\base\Model;
use thread\app\model\interfaces\search\BaseBackendSearchModel;
use backend\modules\catalog\models\{
    Specification as SpecificationModel, SpecificationLang
};

/**
 * Class Specification
 *
 * @package backend\modules\catalog\models\search
 */
class Specification extends SpecificationModel implements BaseBackendSearchModel
{
    public $title;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['id', 'parent_id'], 'integer'],
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
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => false
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            self::tableName() . '.id' => $this->id,
            self::tableName() . '.parent_id' => $this->parent_id
        ]);

        $query
            ->andFilterWhere(['like', self::tableName() . '.alias', $this->alias])
            ->andFilterWhere(['=', self::tableName() . '.published', $this->published]);

        $query->andFilterWhere(['like', SpecificationLang::tableName() . '.title', $this->title]);

        return $dataProvider;
    }

    /**
     * @param $params
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = SpecificationModel::findBase()->undeleted();
        return $this->baseSearch($query, $params);
    }

    /**
     * @param $params
     * @return ActiveDataProvider
     */
    public function trash($params)
    {
        $query = SpecificationModel::findBase()->deleted();
        return $this->baseSearch($query, $params);
    }
}
