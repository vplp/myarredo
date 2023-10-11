<?php

namespace frontend\modules\payment\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
//
use frontend\modules\payment\models\{
    Payment as PaymentModel
};

/**
 * Class Payment
 *
 * @package frontend\modules\payment\models\search
 */
class Payment extends PaymentModel
{
    public $title;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['id', 'user_id'], 'integer'],
            [['type'], 'in', 'range' => array_keys(PaymentModel::getTypeKeyRange())],
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
        /** @var PaymentModele $module */
        $module = Yii::$app->getModule('payment');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'defaultPageSize' => $module->itemOnPage,
                'forcePageParam' => false,
            ],
        ]);

        if (!($this->load($params, '') && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            self::tableName() . '.id' => $this->id,
            self::tableName() . '.user_id' => $this->user_id,
            self::tableName() . '.type' => $this->type
        ]);

//        self::getDb()->cache(function ($db) use ($dataProvider) {
//            $dataProvider->prepare();
//        }, 60 * 60, self::generateDependency(self::find()));

        return $dataProvider;
    }

    /**
     * @param $params
     * @return mixed|ActiveDataProvider
     * @throws \Throwable
     * @throws \yii\base\InvalidConfigException
     */
    public function search($params)
    {
        $query = PaymentModel::findBase();
        return $this->baseSearch($query, $params);
    }
}
