<?php

namespace backend\modules\page\models\search;

use Yii;
use yii\data\ActiveDataProvider;
use yii\base\Model;
//
use thread\app\base\models\query\ActiveQuery;
use thread\app\model\interfaces\search\BaseBackendSearchModel;
//
use backend\modules\page\Page as PageModule;
use backend\modules\page\models\{
    PageLang, Page as PageModel
};

/**
 * Class Page
 *
 * @package backend\modules\page\models\search
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class Page extends PageModel implements BaseBackendSearchModel
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
        /** @var PageModule $module */
        $module = Yii::$app->getModule('page');
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
        /**
         * Sort by no module attributes
         */
        $dataProvider->sort->attributes['title'] = [
            'asc' => ['title' => SORT_ASC],
            'desc' => ['title' => SORT_DESC],
        ];

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'alias', $this->alias])
            ->andFilterWhere(['like', 'published', $this->published]);
        //
        $query->andFilterWhere(['like', PageLang::tableName() . '.title', $this->title]);

        return $dataProvider;
    }

    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = PageModel::find()->joinWith(['lang'])->undeleted();
        return $this->baseSearch($query, $params);
    }

    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function trash($params)
    {
        $query = PageModel::find()->joinWith(['lang'])->deleted();
        return $this->baseSearch($query, $params);
    }
}
