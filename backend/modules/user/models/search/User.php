<?php

namespace backend\modules\user\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\ActiveQuery;
//
use thread\app\model\interfaces\search\BaseBackendSearchModel;
//
use backend\modules\user\models\Profile;
use backend\modules\user\models\User as UserModel;

/**
 * Class User
 *
 * @package admin\modules\user\models\search
 */
class User extends UserModel implements BaseBackendSearchModel
{
    public $country_id;
    public $city_id;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['username', 'email'], 'string', 'max' => 255],
            [['group_id', 'country_id', 'city_id'], 'integer'],
            [['published'], 'in', 'range' => array_keys(self::statusKeyRange())],
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
            self::tableName() . '.id' => $this->id,
            self::tableName() . '.group_id' => $this->group_id,
            Profile::tableName() . '.country_id' => $this->country_id,
            Profile::tableName() . '.city_id' => $this->city_id,
        ]);

        $query->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'published', $this->published]);

        return $dataProvider;
    }

    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = UserModel::findBase()->undeleted();
        return $this->baseSearch($query, $params);
    }

    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function trash($params)
    {
        $query = UserModel::findBase()->deleted();
        return $this->baseSearch($query, $params);
    }
}
