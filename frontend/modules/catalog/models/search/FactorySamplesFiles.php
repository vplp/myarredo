<?php

namespace frontend\modules\catalog\models\search;

use frontend\modules\catalog\models\FactorySamplesFiles as FactorySamplesFilesModel;
use frontend\modules\catalog\Catalog;
use Throwable;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class FactorySamplesFiles extends FactorySamplesFilesModel
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['factory_id'], 'integer'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * @return array
     */
    public function scenarios(): array
    {
        return Model::scenarios();
    }

    /**
     * @param $query
     * @param $params
     * 
     * @return ActiveDataProvider
     * 
     * @throws Throwable
     * @throws \yii\base\InvalidConfigException
     */
    public function baseSearch($query, $params)
    {
        /** @var Catalog $module */
        $module = Yii::$app->getModule('catalog');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'defaultPageSize' => $module->itemOnPage,
                'forcePageParam' => false,
            ],
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            self::tableName() . '.id' => $this->id,
            self::tableName() . '.factory_id' => $this->factory_id,
        ]);

        $query->andFilterWhere(['like', self::tableName() . '.published', $this->published]);

        $query->andFilterWhere(['like', self::tableName() . '.title', $this->title]);

        return $dataProvider;
    }

    /**
     * @param $params
     * 
     * @return ActiveDataProvider
     * 
     * @throws Throwable
     * @throws \yii\base\InvalidConfigException
     */
    public function search($params): ActiveDataProvider
    {
        $query = FactorySamplesFilesModel::findBase()->undeleted();
        return $this->baseSearch($query, $params);
    }

    /**
     * @param $params
     * @return mixed|ActiveDataProvider
     * @throws \Throwable
     */
    public function trash($params)
    {
        $query = FactorySamplesFilesModel::findBase()->deleted();
        return $this->baseSearch($query, $params);
    }
}