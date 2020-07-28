<?php

namespace backend\modules\catalog\models\search;

use Yii;
use yii\data\ActiveDataProvider;
use yii\base\Model;
use thread\app\model\interfaces\search\BaseBackendSearchModel;
use backend\modules\catalog\models\{
    Types as TypesModel, TypesLang, TypesRelCategory
};

/**
 * Class Types
 *
 * @package backend\modules\catalog\models\search
 */
class Types extends TypesModel implements BaseBackendSearchModel
{
    public $title;
    public $category;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['category'], 'integer'],
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

        $query->andWhere([self::tableName() . '.parent_id' => Yii::$app->getRequest()->get('parent_id') ?? '']);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query
            ->andFilterWhere(['like', self::tableName() . '.alias', $this->alias])
            ->andFilterWhere(['=', self::tableName() . '.published', $this->published]);

        $query->andFilterWhere(['like', TypesLang::tableName() . '.title', $this->title]);

        if ($this->category) {
            $query->innerJoinWith(["category"])
                ->andFilterWhere([TypesRelCategory::tableName() . '.group_id' => $this->category]);
        }

        return $dataProvider;
    }

    /**
     * @param $params
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = TypesModel::findBase()->undeleted();
        return $this->baseSearch($query, $params);
    }

    /**
     * @param $params
     * @return ActiveDataProvider
     */
    public function trash($params)
    {
        $query = TypesModel::findBase()->deleted();
        return $this->baseSearch($query, $params);
    }
}
