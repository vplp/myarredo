<?php

namespace frontend\modules\catalog\models\search;

use Yii;
use yii\data\ActiveDataProvider;
use yii\base\Model;
use frontend\modules\catalog\models\{
    SubTypes as SubTypesModel
};

/**
 * Class SubTypes
 *
 * @package frontend\modules\catalog\models\search
 */
class SubTypes extends SubTypesModel
{
    public $title;

    /**
     * @return array
     */
    public function rules()
    {
        return [
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
            'pagination' => [
                'defaultPageSize' => $module->itemOnPage,
                'forcePageParam' => false,
            ],
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'alias', $this->alias]);

        $query->andFilterWhere(['like', SubTypesLang::tableName() . '.title', $this->title]);

        self::getDb()->cache(function ($db) use ($dataProvider) {
            $dataProvider->prepare();
        }, Yii::$app->params['cache']['duration'], self::generateDependency(self::find()));

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
        $query = SubTypesModel::findBase();
        return $this->baseSearch($query, $params);
    }
}
