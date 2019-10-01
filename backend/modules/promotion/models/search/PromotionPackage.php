<?php

namespace backend\modules\promotion\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
//
use backend\modules\promotion\models\{
    PromotionPackage as PromotionPackageModel, PromotionPackageLang
};
//
use thread\app\base\models\query\ActiveQuery;
use thread\app\model\interfaces\search\BaseBackendSearchModel;

/**
 * Class PromotionPackage
 *
 * @package backend\modules\promotion\models\search
 */
class PromotionPackage extends PromotionPackageModel implements BaseBackendSearchModel
{
    public $title;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['title'], 'string', 'max' => 255],
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
        /** @var PromotionModule $module */
        $module = Yii::$app->getModule('promotion');
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => $module->itemOnPage
            ]
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere(['=', 'published', $this->published]);

        $query->andFilterWhere(['like', PromotionPackageLang::tableName() . '.title', $this->title]);

        return $dataProvider;
    }

    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = PromotionPackageModel::findBase()->undeleted();
        return $this->baseSearch($query, $params);
    }

    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function trash($params)
    {
        $query = PromotionPackageModel::findBase()->deleted();
        return $this->baseSearch($query, $params);
    }
}
