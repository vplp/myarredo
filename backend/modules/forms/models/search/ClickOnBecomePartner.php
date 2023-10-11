<?php

namespace backend\modules\forms\models\search;

use Yii;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;

//
use thread\app\model\interfaces\search\BaseBackendSearchModel;
use thread\app\base\models\query\ActiveQuery;

//
use backend\modules\forms\models\ClickOnBecomePartner as ParentModel;
use backend\modules\forms\FormsModule;

/**
 * Class ClickOnBecomePartner
 *
 * @package backend\modules\forms\models\search
 */
class ClickOnBecomePartner extends ParentModel implements BaseBackendSearchModel
{
    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['country_id', 'city_id'], 'integer']
        ];
    }

    /**
     *
     * @return array
     */
    public function scenarios()
    {
        return ArrayHelper::merge(\yii\base\Model::scenarios(), parent::scenarios());
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
            ]
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'country_id' => $this->country_id,
            'city_id' => $this->city_id,
        ]);

        return $dataProvider;
    }

    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = ParentModel::findBase();
        return $this->baseSearch($query, $params);
    }

    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function trash($params)
    {
        $query = ParentModel::findBase();
        return $this->baseSearch($query, $params);
    }
}
