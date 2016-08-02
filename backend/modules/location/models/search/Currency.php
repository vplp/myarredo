<?php

namespace backend\modules\location\models\search;

use Yii;
use yii\data\ActiveDataProvider;
use yii\base\Model;
//
use backend\modules\location\Location as LocationModule;
use backend\modules\location\models\Currency as CurrencyModel;
use backend\modules\location\models\CurrencyLang;

class Currency extends CurrencyModel
{
    public $title;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['course'], 'double'],
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
                    'pageSize' => $module->itemOnPage
                ],
                'sort' => [
                    'defaultOrder' => [
                        'id' => SORT_ASC
                    ]
                ]
            ]
        );

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere(
            [
                'course' => $this->course,
            ]
        );

        $query->andFilterWhere(['like', 'alias', $this->alias])
            ->andFilterWhere(['like', 'published', $this->published]);
        //
        $query->andFilterWhere(['like', CurrencyLang::tableName() . '.title', $this->title]);

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
        $query = CurrencyModel::find()->joinWith(['lang'])->undeleted();
        return $this->baseSearch($query, $params);
    }

    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function trash($params)
    {
        $query = CurrencyModel::find()->joinWith(['lang'])->deleted();
        return $this->baseSearch($query, $params);
    }
}
