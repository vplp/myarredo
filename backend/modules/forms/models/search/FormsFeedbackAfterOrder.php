<?php

namespace backend\modules\forms\models\search;

use Yii;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
//
use thread\app\model\interfaces\search\BaseBackendSearchModel;
use thread\app\base\models\query\ActiveQuery;
//
use backend\modules\forms\models\FormsFeedbackAfterOrder as FormsFeedbackAfterOrderModel;
use backend\modules\forms\FormsModule;

/**
 * Class FormsFeedback
 *
 * @package backend\modules\forms\models\search
 */
class FormsFeedbackAfterOrder extends FormsFeedbackAfterOrderModel implements BaseBackendSearchModel
{
    public $title;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['created_at', 'updated_at', 'user_id', 'order_id'], 'integer'],
            [['published', 'deleted'], 'in', 'range' => array_keys(static::statusKeyRange())],
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
            'published' => $this->published,
        ]);

        return $dataProvider;
    }

    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = FormsFeedbackAfterOrderModel::findBase()->undeleted();
        return $this->baseSearch($query, $params);
    }

    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function trash($params)
    {
        $query = FormsFeedbackAfterOrderModel::findBase()->deleted();
        return $this->baseSearch($query, $params);
    }
}
