<?php

namespace backend\modules\shop\models\search;

use Yii;
use yii\data\ActiveDataProvider;
use yii\base\Model;
//
use thread\app\base\models\query\ActiveQuery;
use thread\app\model\interfaces\search\BaseBackendSearchModel;
//
use backend\modules\shop\Shop as ShopModule;
use backend\modules\shop\models\DeliveryMethods as DeliveryMethodsModel;

/**
 * Class DeliveryMethods
 *
 * @package backend\modules\shop\models\search
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class DeliveryMethods extends DeliveryMethodsModel implements BaseBackendSearchModel
{

    /**
     * @return array
     */
    public function rules()
    {
        return [
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
        $module = Yii::$app->getModule('shop');
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

        return $dataProvider;
    }

    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = DeliveryMethodsModel::find()->undeleted();
        return $this->baseSearch($query, $params);
    }

    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function trash($params)
    {
        $query = DeliveryMethodsModel::find()->deleted();
        return $this->baseSearch($query, $params);
    }
}
