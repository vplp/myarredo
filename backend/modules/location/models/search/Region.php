<?php

namespace backend\modules\location\models\search;

use Yii;
use yii\data\ActiveDataProvider;
use yii\base\Model;
//
use thread\app\model\interfaces\search\BaseBackendSearchModel;
//
use backend\modules\location\Location as LocationModule;
use backend\modules\location\models\{
    Region as RegionModel, RegionLang
};

/**
 * Class Region
 *
 * @package backend\modules\location\models\search
 */
class Region extends RegionModel implements BaseBackendSearchModel
{
    public $title;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['country_id'], 'integer'],
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
     * @param ActiveQuery $query
     * @param array $params
     * @return ActiveDataProvider
     */
    public function baseSearch($query, $params)
    {
        /** @var LocationModule $module */
        $module = Yii::$app->getModule('location');
        $dataProvider = new ActiveDataProvider(
            [
                'query' => $query,
                'pagination' => [
                    'defaultPageSize' => $module->itemOnPage
                ]
            ]
        );

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'country_id' => $this->country_id,
        ]);

        $query->andFilterWhere(['like', 'alias', $this->alias])
            ->andFilterWhere(['=', 'published', $this->published]);
        //
        $query->andFilterWhere(['like', RegionLang::tableName() . '.title', $this->title]);

        return $dataProvider;
    }

    /**
     * Search
     *
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = RegionModel::findBase()->undeleted();
        return $this->baseSearch($query, $params);
    }

    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function trash($params)
    {
        $query = RegionModel::findBase()->deleted();
        return $this->baseSearch($query, $params);
    }
}
