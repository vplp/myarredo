<?php

namespace backend\modules\payment\models\search;

use Yii;
use yii\data\ActiveDataProvider;
use yii\base\Model;
//
use thread\app\base\models\query\ActiveQuery;
use thread\app\model\interfaces\search\BaseBackendSearchModel;
//
use backend\modules\payment\{
    Shop as ShopModule, models\Payment as PaymentModel
};

/**
 * Class Payment
 *
 * @package backend\modules\payment\models\search
 */
class Payment extends PaymentModel implements BaseBackendSearchModel
{
    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['user_id'], 'integer'],
            [['payment_status'], 'in', 'range' => array_keys(self::paymentStatusRange())],
            [['type'], 'in', 'range' => array_keys(self::getTypeKeyRange())],
            [['published'], 'in', 'range' => array_keys(self::statusKeyRange())],
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
        /** @var ShopModule $module */
        $module = Yii::$app->getModule('payment');
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'defaultPageSize' => $module->itemOnPage
            ]
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            self::tableName() . '.id' => $this->id,
            self::tableName() . '.user_id' => $this->user_id,
        ]);

        $query
            ->andFilterWhere(['=', self::tableName() . '.payment_status', $this->payment_status])
            ->andFilterWhere(['=', self::tableName() . '.type', $this->type]);


        return $dataProvider;
    }

    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = PaymentModel::findBase()->undeleted();
        return $this->baseSearch($query, $params);
    }

    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function trash($params)
    {
        $query = PaymentModel::findBase()->deleted();
        return $this->baseSearch($query, $params);
    }
}
