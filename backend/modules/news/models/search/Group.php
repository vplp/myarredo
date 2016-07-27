<?php
namespace backend\modules\news\models\search;

use backend\modules\news\News as NewsModule;
use thread\app\base\models\query\ActiveQuery;
use Yii;
use yii\data\ActiveDataProvider;
use backend\modules\news\models\Group as GroupModel;

class Group extends GroupModel
{
    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['id', 'created_at', 'updated_at'], 'integer'],
            [['alias'], 'string', 'max' => 255],
        ];
    }

    /**
     * @param ActiveQuery $query
     * @param array $params
     * @return ActiveDataProvider
     */
    public function baseSearch($query, $params)
    {
        /** @var NewsModule $module */
        $module = Yii::$app->getModule('news');
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

        $query->andFilterWhere([
            'id' => $this->id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'alias', $this->alias])
                ->andFilterWhere(['like', 'published', $this->published])
                ->andFilterWhere(['like', 'deleted', $this->deleted]);

        return $dataProvider;
    }

    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = GroupModel::find()->with(['lang'])->undeleted();
        return $this->baseSearch($query, $params);
    }

    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function trash($params)
    {
        $query = GroupModel::find()->with(['lang'])->deleted();
        return $this->baseSearch($query, $params);
    }
}
