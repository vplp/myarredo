<?php

namespace backend\modules\user\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\user\models\Group as GroupModel;
use yii\db\ActiveQuery;

/**
 * Class Group
 *
 * @package admin\modules\user\models\search
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c) 2015, Thread
 */
class Group extends GroupModel
{
    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['alias'], 'string', 'max' => 255],
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
    public function baseSearch(ActiveQuery $query, $params)
    {
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => Yii::$app->modules['user']->itemOnPage
            ]
        ]);
        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }
        $query->andFilterWhere([
            'id' => $this->id,
        ]);
        $query->andFilterWhere(['like', 'alias', $this->alias]);
        return $dataProvider;
    }

    /**
     *
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = GroupModel::find()->joinWith(['lang'])->undeleted();
        return $this->baseSearch($query, $params);
    }

    /**
     *
     * @param array $params
     * @return ActiveDataProvider
     */
    public function trash($params)
    {
        $query = GroupModel::find()->joinWith(['lang'])->deleted();
        return $this->baseSearch($query, $params);
    }
}
