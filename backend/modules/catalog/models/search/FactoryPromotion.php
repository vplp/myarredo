<?php

namespace backend\modules\catalog\models\search;

use Yii;
use yii\data\ActiveDataProvider;
use yii\base\Model;
use thread\app\model\interfaces\search\BaseBackendSearchModel;
use backend\modules\catalog\Catalog;
use backend\modules\catalog\models\{
    FactoryPromotion as FactoryPromotionModel
};

/**
 * Class FactoryPromotion
 *
 * @package backend\modules\catalog\models\search
 */
class FactoryPromotion extends FactoryPromotionModel implements BaseBackendSearchModel
{
    public $title;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['id', 'factory_id', 'user_id'], 'integer'],
            [['status', 'published'], 'in', 'range' => array_keys(self::statusKeyRange())],
            [['payment_status'], 'in', 'range' => array_keys(static::paymentStatusRange())],
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
     * @param $query
     * @param $params
     * @return ActiveDataProvider
     */
    public function baseSearch($query, $params)
    {
        /** @var Catalog $module */
        $module = Yii::$app->getModule('catalog');
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'defaultPageSize' => $module->itemOnPage
            ],
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            self::tableName() . '.id' => $this->id,
            self::tableName() . '.user_id' => $this->user_id,
            self::tableName() . '.factory_id' => $this->factory_id,
            self::tableName() . '.status' => $this->status,
            self::tableName() . '.payment_status' => $this->payment_status,
            self::tableName() . '.published' => $this->published
        ]);

        return $dataProvider;
    }

    /**
     * @param $params
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = FactoryPromotionModel::findBase()->undeleted();
        return $this->baseSearch($query, $params);
    }

    /**
     * @param $params
     * @return ActiveDataProvider
     */
    public function trash($params)
    {
        $query = FactoryPromotionModel::findBase()->deleted();
        return $this->baseSearch($query, $params);
    }
}
