<?php
namespace backend\modules\forms\models\search;

use backend\modules\forms\Forms as FormsModule;
use thread\app\base\models\query\ActiveQuery;
use Yii;
use yii\data\ActiveDataProvider;
use backend\modules\forms\models\FeedbackForm as FeedbackFormModel;

class FeedbackForm extends FeedbackFormModel
{
    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['name', 'question','topic_id', 'email'], 'required'],
            [['topic_id', 'created_at', 'updated_at'], 'integer'],
            [['name', 'question'], 'string', 'max' => 255],
            [['email'], 'email'],
            [['phone'], 'string', 'max' => 20],
            [['phone'], 'string', 'max' => 5],
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
                    'id' => SORT_ASC
                ]
            ]
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->joinWith(['topics']);

        $query->andFilterWhere([
            'id' => $this->id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);


        return $dataProvider;
    }

    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = FeedbackFormModel::find()->with(['topics'])->undeleted();
        return $this->baseSearch($query, $params);
    }

    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function trash($params)
    {
        $query = FeedbackFormModel::find()->with(['topics'])->deleted();
        return $this->baseSearch($query, $params);
    }
}
