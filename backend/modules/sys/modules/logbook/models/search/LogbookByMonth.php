<?php

namespace backend\modules\sys\modules\logbook\models\search;

use backend\modules\sys\modules\logbook\Logbook as ParentModule;
use backend\modules\sys\modules\logbook\models\{LogbookByMonth as ParentModel};
use thread\app\base\models\query\ActiveQuery;
use thread\app\model\interfaces\search\BaseBackendSearchModel;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * Class LogbookByMonth
 *
 * @package backend\modules\sys\modules\logbook\models\search
 */
class LogbookByMonth extends ParentModel implements BaseBackendSearchModel
{
    public $date_from;
    public $date_to;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['user_id'], 'integer'],
            [['action_method'], 'string', 'max' => 512],
            [
                ['action_date'],
                'date',
                'format' => 'php: d.m.Y',
                'timestampAttribute' => 'action_date'
            ],
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
                    'action_date' => SORT_DESC,
                ]
            ]
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere(['>=', self::tableName() . '.action_date', $this->date_from]);
        $query->andFilterWhere(['<=', self::tableName() . '.action_date', $this->date_to]);

        $query->andFilterWhere(['=', self::tableName() . '.user_id', $this->user_id]);
        $query->andFilterWhere(['=', self::tableName() . '.action_method', $this->action_method]);

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
