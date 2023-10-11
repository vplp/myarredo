<?php

namespace backend\modules\sys\modules\logbook\models\search;

use backend\modules\sys\modules\logbook\Logbook as ParentModule;
use backend\modules\sys\modules\logbook\models\{Logbook as ParentModel};
use thread\app\base\models\query\ActiveQuery;
use thread\app\model\interfaces\search\BaseBackendSearchModel;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * Class Logbook
 *
 * @package backend\modules\sys\modules\logbook\models\search
 */
class Logbook extends ParentModel implements BaseBackendSearchModel
{
    public $title;
    public $date_from;
    public $date_to;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['created_at', 'model_id', 'user_id'], 'integer'],
            [['message', 'category', 'model_name'], 'string', 'max' => 512],
            [['published'], 'in', 'range' => array_keys(self::statusKeyRange())],
            [
                ['date_from'],
                'date',
                'format' => 'php: d.m.Y',
                'timestampAttribute' => 'date_from'
            ],
            [
                ['date_to'],
                'date',
                'format' => 'php: d.m.Y',
                'timestampAttribute' => 'date_to'
            ],
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
     * @param ActiveQuery $query
     * @param array $params
     * @return ActiveDataProvider
     */
    public function baseSearch($query, $params)
    {
        /** @var ParentModule $module */
        $module = Yii::$app->getModule('sys');
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => $module->itemOnPage
            ],
            'sort' => [
                'defaultOrder' => [
                    'is_read' => SORT_ASC,
                    'created_at' => SORT_DESC,
                ]
            ]
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query
            ->andFilterWhere([self::tableName() . '.model_id' => $this->model_id])
            ->andFilterWhere([self::tableName() . '.user_id' => $this->user_id])
            ->andFilterWhere([self::tableName() . '.model_name' => $this->model_name])
            ->andFilterWhere(['like', self::tableName() . '.published', $this->published])
            ->andFilterWhere(['like', self::tableName() . '.category', $this->category])
            ->andFilterWhere(['like', self::tableName() . '.message', $this->message]);

        $query->andFilterWhere(['<=', self::tableName() . '.created_at', $this->date_to]);

        return $dataProvider;
    }

    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = ParentModel::find()->undeleted();
        return $this->baseSearch($query, $params);
    }

    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function trash($params)
    {
        $query = ParentModel::find()->deleted();
        return $this->baseSearch($query, $params);
    }
}
