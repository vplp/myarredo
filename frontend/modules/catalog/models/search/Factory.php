<?php

namespace frontend\modules\catalog\models\search;

use Yii;
use yii\data\ActiveDataProvider;
use yii\base\Model;
use frontend\modules\catalog\models\{Factory as FactoryModel, Product};

/**
 * Class Factory
 *
 * @package frontend\modules\catalog\models\search
 */
class Factory extends FactoryModel
{
    public $letter;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['producing_country_id'], 'integer'],
            [['letter'], 'string', 'max' => 1],
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
     * @throws \Throwable
     * @throws \yii\base\InvalidConfigException
     */
    public function baseSearch($query, $params)
    {
        /** @var Catalog $module */
        $module = Yii::$app->getModule('catalog');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => (Yii::$app->request->get('view')) ? false : [
                'defaultPageSize' => $module->itemOnPage,
                'forcePageParam' => false,
            ],
        ]);

        if (!($this->load($params, '') && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere(['like', self::tableName() . '.alias', $this->alias]);
        $query->andFilterWhere(['like', self::tableName() . '.title', $this->title]);
        $query->andFilterWhere(['like', self::tableName() . '.first_letter', $this->letter]);

        if (isset($params['producing_country_id'])) {
            $query->andFilterWhere(['IN', self::tableName() . '.producing_country_id', $params['producing_country_id']]);
        }

        self::getDb()->cache(function ($db) use ($dataProvider) {
            $dataProvider->prepare();
        }, 60 * 60 * 3, self::generateDependency(self::find()));

        return $dataProvider;
    }

    /**
     * @param $params
     * @return ActiveDataProvider
     * @throws \Throwable
     * @throws \yii\base\InvalidConfigException
     */
    public function search($params)
    {
        $query = FactoryModel::findBase();

        $query
            ->select([
                self::tableName() . '.id',
                self::tableName() . '.alias',
                self::tableName() . '.image_link',
                self::tableName() . '.title',
            ])
            ->andFilterWhere(['<>', self::tableName() . '.product_count', 0])
            ->groupBy(self::tableName() . '.id')
            ->asArray();

        return $this->baseSearch($query, $params);
    }
}
