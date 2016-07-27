<?php

namespace backend\modules\menu\models\search;

use backend\modules\menu\Menu as MenuModule;
use Yii;
use yii\data\ActiveDataProvider;
use backend\modules\menu\models\Menu as MenuModel;
use yii\db\Query;

class Menu extends MenuModel
{
    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['id', 'created_at', 'updated_at'], 'integer'],
            [['alias'], 'string', 'max' => 255],
        ];
    }

    /**
     * Description
     *
     * @param $query
     * @param $params
     * @return ActiveDataProvider
     */
    public function baseSearch($query, $params)
    {
        /** @var MenuModule $module */
        $module = Yii::$app->getModule('menu');
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

        /** @var $query Query */
        $query->andFilterWhere(
            [
                'id' => $this->id,
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at,
            ]
        );

        $query->andFilterWhere(['like', 'alias', $this->alias])
            ->andFilterWhere(['like', 'published', $this->published])
            ->andFilterWhere(['like', 'deleted', $this->deleted]);

        return $dataProvider;
    }

    /**
     * Description
     *
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = MenuModel::find()->with(['lang'])->undeleted();
        return $this->baseSearch($query, $params);
    }

    /**
     * Description
     *
     * @param $params
     * @return ActiveDataProvider
     */
    public function trash($params)
    {
        $query = MenuModel::find()->with(['lang'])->deleted();
        return $this->baseSearch($query, $params);
    }
}
