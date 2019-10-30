<?php

namespace frontend\modules\user\models\search;

use Yii;
use yii\base\Model;
use yii\db\ActiveQuery;
use yii\data\ActiveDataProvider;
//
use frontend\modules\user\models\{
    User as UserModel, Profile, ProfileLang
};

/**
 * Class User
 *
 * @package frontend\modules\user\models\search
 */
class User extends UserModel
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
        $module = Yii::$app->getModule('user');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'defaultPageSize' => $module->itemOnPage
            ]
        ]);

        if (!($this->load($params, ''))) {
            return $dataProvider;
        }

        if ($params['group_id']) {
            $query->andFilterWhere([
                self::tableName() . '.group_id' => $params['group_id']
            ]);
        }

        if ($params['country_id']) {
            $query->andFilterWhere([
                Profile::tableName() . '.country_id' => $params['country_id']
            ]);
        }

        if ($params['city_id']) {
            $query->andFilterWhere([
                Profile::tableName() . '.city_id' => $params['city_id']
            ]);
        }

        $query->orderBy(ProfileLang::tableName() . '.name_company ASC');

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
        $query = UserModel::findBase();
        return $this->baseSearch($query, $params);
    }
}
