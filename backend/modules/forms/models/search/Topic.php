<?php
namespace backend\modules\forms\models\search;

use backend\modules\forms\Forms as FormsModule;
use thread\app\base\models\query\ActiveQuery;
use Yii;
use yii\data\ActiveDataProvider;
use backend\modules\forms\models\Topic as TopicModel;

class Topic extends TopicModel
{
    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['id', 'created_at', 'updated_at', 'sort'], 'integer'],
        ];
    }

    /**
     * @param ActiveQuery $query
     * @param array $params
     * @return ActiveDataProvider
     */
    public function baseSearch($query, $params)
    {
        /** @var FormsModule $module */
        $module = Yii::$app->getModule('forms');
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => $module->itemOnPage
            ],
            'sort' => [
                'defaultOrder' => [
                    'sort' => SORT_DESC
                ]
            ]
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'published', $this->published])
            ->andFilterWhere(['like', 'deleted', $this->deleted]);

        return $dataProvider;
    }

    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = TopicModel::find()->with(['lang'])->undeleted();
        return $this->baseSearch($query, $params);
    }

    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function trash($params)
    {
        $query = TopicModel::find()->with(['lang'])->deleted();
        return $this->baseSearch($query, $params);
    }
}