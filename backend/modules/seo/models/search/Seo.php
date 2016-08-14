<?php

namespace backend\modules\seo\models\search;

use Yii;
use yii\data\ActiveDataProvider;
//
use backend\modules\seo\Seo as SeoModule;
use backend\modules\seo\models\Seo as SeoModel;

/**
 * Class Seo
 *
 * @package backend\modules\seo\models\search
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class Seo extends SeoModel
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
        $query = SeoModel::find()->with(['lang'])->undeleted();
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
        $query = SeoModel::find()->with(['lang'])->deleted();
        return $this->baseSearch($query, $params);
    }
}
