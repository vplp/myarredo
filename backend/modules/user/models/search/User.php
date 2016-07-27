<?php

namespace backend\modules\user\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\user\models\User as UserModel;
use yii\db\ActiveQuery;

/**
 * Class User
 *
 * @package admin\modules\user\models\search
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c) 2015, Thread
 */
class User extends UserModel
{
    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['username', 'email'], 'string', 'max' => 255],
            [['group_id'], 'integer'],
            [['sanatorium_id', 'company_id'], 'safe'],
        ];
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
        
        $query->joinWith('group');

        $query->andFilterWhere([
            'id' => $this->id,
            'group_id' => $this->group_id
        ]);

        $query->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'email', $this->email]);
        return $dataProvider;
    }

    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = UserModel::find()->joinWith([
                    'group', 'group.lang',
                ])->undeleted();
        return $this->baseSearch($query, $params);
    }

    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function trash($params)
    {
        $query = UserModel::find()->joinWith([
                    'group', 'group.lang',
                ])->deleted();
        return $this->baseSearch($query, $params);
    }
}
