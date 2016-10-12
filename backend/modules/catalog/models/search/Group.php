<?php

namespace backend\modules\catalog\models\search;

use Yii;
//
use yii\data\ActiveDataProvider;
//
use yii\base\Model;
//
use thread\app\base\models\query\ActiveQuery;
//
use thread\app\model\interfaces\search\BaseBackendSearchModel;
//
use backend\modules\catalog\Catalog as CatalogModule;
//
use backend\modules\catalog\models\{
    Group as GroupModel, GroupLang
};

/**
 * Class Group
 *
 * @package backend\modules\catalog\models\search
 * @author Andrii Bondarchuk
 * @copyright (c) 2016, VipDesign
 */
class Group extends GroupModel implements BaseBackendSearchModel
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
     * @param ActiveQuery $query
     * @param array $params
     * @return ActiveDataProvider
     */
    public function baseSearch($query, $params)
    {
        /** @var CatalogModule $module */
        $module = Yii::$app->getModule('catalog');
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

        $query->andFilterWhere(['like', 'alias', $this->alias])
            ->andFilterWhere(['like', 'published', $this->published]);
        //
        $query->andFilterWhere(['like', GroupLang::tableName() . '.title', $this->title]);

        return $dataProvider;
    }

    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = GroupModel::find()->joinWith(['lang'])->undeleted();
        return $this->baseSearch($query, $params);
    }

    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function trash($params)
    {
        $query = GroupModel::find()->joinWith(['lang'])->deleted();
        return $this->baseSearch($query, $params);
    }
}