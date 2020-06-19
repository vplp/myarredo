<?php

namespace backend\modules\seo\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\seo\Seo as SeoModule;
use backend\modules\seo\models\Redirects as RedirectsModel;
use thread\app\model\interfaces\search\BaseBackendSearchModel;

/**
 * Class Redirects
 *
 * @package backend\modules\seo\models\search
 */
class Redirects extends RedirectsModel implements BaseBackendSearchModel
{
    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['url_from', 'url_to'], 'string', 'max' => 512],
            [['published'], 'in', 'range' => array_keys(self::statusKeyRange())],
        ];
    }

    /**
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
        /** @var SeoModule $module */
        $module = Yii::$app->getModule('seo');

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

        $query->andFilterWhere([
            self::tableName() . '.id' => $this->id
        ]);

        $query->andFilterWhere(['like', self::tableName() . '.url_from', $this->url_from]);
        $query->andFilterWhere(['like', self::tableName() . '.url_to', $this->url_to]);
        $query->andFilterWhere(['=', 'published', $this->published]);

        return $dataProvider;
    }

    /**
     * @param $params
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = RedirectsModel::findBase()->undeleted();
        return $this->baseSearch($query, $params);
    }

    /**
     * @param $params
     * @return ActiveDataProvider
     */
    public function trash($params)
    {
        $query = RedirectsModel::findBase()->deleted();
        return $this->baseSearch($query, $params);
    }
}
