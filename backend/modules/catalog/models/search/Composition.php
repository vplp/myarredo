<?php

namespace backend\modules\catalog\models\search;

use Yii;
use yii\data\ActiveDataProvider;
use yii\base\Model;
use thread\app\model\interfaces\search\BaseBackendSearchModel;
use backend\modules\catalog\Catalog;
use backend\modules\catalog\models\{
    ProductRelCategory, Composition as CompositionModel, CompositionLang
};

/**
 * Class Composition
 *
 * @package backend\modules\catalog\models\search
 */
class Composition extends CompositionModel implements BaseBackendSearchModel
{
    public $title;
    public $category;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['category', 'factory_id', 'editor_id'], 'integer'],
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
            self::tableName() . '.editor_id' => $this->editor_id
        ]);

        $query
            ->andFilterWhere(['like', self::tableName() . '.alias', $this->alias])
            ->andFilterWhere(['=', self::tableName() . '.published', $this->published]);

        $query->andFilterWhere(['like', CompositionLang::tableName() . '.title', $this->title]);

        if ($this->category) {
            $query->innerJoinWith(["category"])
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
        $query = CompositionModel::findBase()->undeleted();
        return $this->baseSearch($query, $params);
    }

    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function searchTranslation($params)
    {
        $query = CompositionModel::findBase()->undeleted();

        $query
            ->andWhere([
                'OR',
                ['=', CompositionLang::tableName() . '.mark', '0'],
                //['=', CompositionLang::tableName() . '.title', ''],
                //['=', CompositionLang::tableName() . '.description', '']
            ]);

        return $this->baseSearch($query, $params);
    }

    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function trash($params)
    {
        $query = CompositionModel::findBase()->deleted();
        return $this->baseSearch($query, $params);
    }
}
