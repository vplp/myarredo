<?php

namespace backend\modules\sys\modules\translation\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use thread\app\model\interfaces\search\BaseBackendSearchModel;
use backend\modules\sys\modules\translation\Translation;
use backend\modules\sys\modules\translation\models\Source as SourceModel;

/**
 * Class Source
 *
 * @author Andrew Kontseba - Skinwalker <andjey.skinwalker@gmail.com>
 * @package backend\modules\sys\modules\translation\models\search
 */
class Source extends SourceModel implements BaseBackendSearchModel
{
    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['key', 'category'], 'string', 'max' => 255],
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
     * @param $query
     * @param $params
     * @return mixed
     */
    public function baseSearch($query, $params)
    {
        /** @var Translation $module */
        $module = Yii::$app->getModule('sys/translation');
        $dataProvider = new ActiveDataProvider(
            [
                'query' => $query,
                'pagination' => [
                    'pageSize' => $module->itemOnPage
                ],
                'sort' => [
                    'defaultOrder' => [
                        'id' => SORT_ASC
                    ]
                ]
            ]
        );

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'published', $this->published]);
        $query->andFilterWhere(['like', 'key', $this->key]);
        $query->andFilterWhere(['like', 'category', $this->category]);

        return $dataProvider;
    }

    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = SourceModel::find()->joinWith(['message'])->undeleted();

        return $this->baseSearch($query, $params);
    }

    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function trash($params)
    {
        $query = SourceModel::find()->joinWith(['message'])->deleted();

        return $this->baseSearch($query, $params);
    }
}
