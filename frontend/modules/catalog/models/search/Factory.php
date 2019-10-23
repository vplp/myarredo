<?php

namespace frontend\modules\catalog\models\search;

use Yii;
use yii\data\ActiveDataProvider;
use yii\base\Model;
//
use frontend\modules\catalog\models\{Factory as FactoryModel, FactoryLang, Product};

/**
 * Class Factory
 *
 * @package frontend\modules\catalog\models\search
 */
class Factory extends FactoryModel
{
    public $title;
    public $letter;

    /**
     * @return array
     */
    public function rules()
    {
        return [
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

        $query->andFilterWhere(['like', 'alias', $this->alias]);

        $query->andFilterWhere(['like', FactoryLang::tableName() . '.title', $this->title]);
        $query->andFilterWhere(['like', 'first_letter', $this->letter]);

        self::getDb()->cache(function ($db) use ($dataProvider) {
            $dataProvider->prepare();
        });

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
                Factory::tableName() . '.id',
                Factory::tableName() . '.alias',
                Factory::tableName() . '.image_link',
                Factory::tableName() . '.title',
            ])
            ->innerJoinWith(['lang'], false)
            ->innerJoinWith(["product"], false)
            ->innerJoinWith(["product.lang"], false)
            ->andFilterWhere([
                Product::tableName() . '.published' => '1',
                Product::tableName() . '.deleted' => '0',
                Product::tableName() . '.removed' => '0',
            ])
            ->groupBy(self::tableName() . '.id');

        return $this->baseSearch($query, $params);
    }
}
