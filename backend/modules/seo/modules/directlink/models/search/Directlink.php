<?php

namespace backend\modules\seo\modules\directlink\models\search;

use Yii;
use yii\data\ActiveDataProvider;
use yii\base\Model;
//
use thread\app\base\models\query\ActiveQuery;
use thread\app\model\interfaces\search\BaseBackendSearchModel;
//
use backend\modules\seo\modules\directlink\Directlink as ParentModule;
use backend\modules\seo\modules\directlink\models\{
    Directlink as ParentModel
};

/**
 * Class Directlink
 *
 * @property string $title
 * @property integer $city_id
 *
 * @package backend\modules\seo\modules\directlink\models\search
 */
class Directlink extends ParentModel implements BaseBackendSearchModel
{
    public $title;
    public $city_id;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['url'], 'string', 'max' => 255],
            [['id', 'city_id'], 'integer'],
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
        /** @var ParentModule $module */
        $module = Yii::$app->getModule('seo/directlink');
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
            self::tableName() . '.id' => $this->id
        ]);

        if ($this->city_id) {
            $query
                ->innerJoinWith(["cities"])
                ->andFilterWhere(['IN', 'location_city_id', $this->city_id]);
        }

        $query->andFilterWhere(['like', 'url', $this->url])
            ->andFilterWhere(['=', 'published', $this->published]);

        return $dataProvider;
    }

    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = ParentModel::findBase()->undeleted();
        return $this->baseSearch($query, $params);
    }

    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function trash($params)
    {
        $query = ParentModel::findBase()->deleted();
        return $this->baseSearch($query, $params);
    }
}
