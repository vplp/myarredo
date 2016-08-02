<?php

namespace backend\modules\menu\models\search;

use Yii;
use yii\data\ActiveDataProvider;
use yii\base\Model;
//
use thread\app\model\interfaces\search\BaseBackendSearchModel;
//
use backend\modules\menu\Menu as MenuModule;
use backend\modules\menu\models\{
    MenuItem as MenuItemModel, MenuItemLang
};

class MenuItem extends MenuItemModel implements BaseBackendSearchModel
{
    public $title;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['alias', 'title'], 'string', 'max' => 255],
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
        $query->andFilterWhere(['like', 'alias', $this->alias])
            ->andFilterWhere(['like', 'published', $this->published]);
        //
        $query->andFilterWhere(['like', MenuItemLang::tableName() . '.title', $this->title]);

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
        $query = MenuItemModel::find()->joinWith(['lang'])->parent_id($parent_id)->undeleted();
        return $this->baseSearch($query, $params);
    }

    /**
     * Description
     * @param $params
     * @return ActiveDataProvider
     */
    public function trash($params)
    {
        $parent_id = Yii::$app->request->get('parent_id', 0);
        $query = MenuItemModel::find()->joinWith(['lang'])->parent_id($parent_id)->deleted();
        return $this->baseSearch($query, $params);
    }
}
