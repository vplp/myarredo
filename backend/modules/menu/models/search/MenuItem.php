<?php

namespace backend\modules\menu\models\search;

use backend\modules\menu\Menu as MenuModule;
use Yii;
use yii\data\ActiveDataProvider;
use backend\modules\menu\models\MenuItem as ItemModel;
use yii\db\Query;

class MenuItem extends ItemModel
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

        $query->andWhere(['group_id' => Yii::$app->getRequest()->get('group_id') ?? '']);

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

        $query->andFilterWhere(['like', 'published', $this->published])
            ->andFilterWhere(['like', 'deleted', $this->deleted]);

        return $dataProvider;
    }

    /**
     * Description
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $parent_id = Yii::$app->request->get('parent_id', 0);
        $query = ItemModel::find()->with(['lang'])->parent_id($parent_id)->undeleted();
        return $this->baseSearch($query, $params);
    }

    /**
     * Description
     * @param $params
     * @return ActiveDataProvider
     */
    public function trash($params)
    {
        $query = ItemModel::find()->with(['lang'])->deleted();
        return $this->baseSearch($query, $params);
    }
}
