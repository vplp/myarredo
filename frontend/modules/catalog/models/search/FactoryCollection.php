<?php

namespace frontend\modules\catalog\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
//
use thread\app\model\interfaces\search\BaseBackendSearchModel;
//
use frontend\modules\catalog\models\{
    FactoryCollection as FactoryCollectionModel
};
use frontend\modules\catalog\Catalog;

/**
 * Class FactoryCollection
 *
 * @package frontend\modules\catalog\models\search
 */
class FactoryCollection extends FactoryCollectionModel implements BaseBackendSearchModel
{
    public $title;
    public $category;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['id', 'factory_id'], 'integer'],
            [['title'], 'string', 'max' => 255],
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
     * @throws \Exception
     * @throws \Throwable
     */
    public function baseSearch($query, $params)
    {
        /** @var Catalog $module */
        $module = Yii::$app->getModule('catalog');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => isset($params['pagination']) ? $params['pagination'] : [
                'defaultPageSize' => $module->itemOnPage,
                'forcePageParam' => false,
            ],
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'factory_id' => $this->factory_id,
        ]);

        $query
            ->andFilterWhere(['like', self::tableName() . '.published', $this->published])
            ->andFilterWhere(['like', self::tableName() . '.title', $this->title]);

        self::getDb()->cache(function ($db) use ($dataProvider) {
            $dataProvider->prepare();
        }, 60 * 60 * 3, self::generateDependency(self::find()));

        return $dataProvider;
    }

    /**
     * @param $params
     * @return ActiveDataProvider
     * @throws \Throwable
     */
    public function search($params)
    {
        $query = FactoryCollectionModel::findBase()->undeleted();
        return $this->baseSearch($query, $params);
    }

    /**
     * @param $params
     * @return mixed|ActiveDataProvider
     * @throws \Throwable
     */
    public function trash($params)
    {
        $query = FactoryCollectionModel::findBase()->deleted();
        return $this->baseSearch($query, $params);
    }
}