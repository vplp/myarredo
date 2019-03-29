<?php

namespace backend\modules\menu\models\search;

use Yii;
use yii\data\ActiveDataProvider;
use yii\base\Model;
//
use thread\app\model\interfaces\search\BaseBackendSearchModel;
//
use backend\modules\menu\Menu as ParentModule;
use backend\modules\menu\models\{
    Menu as ParentModel, MenuLang
};

/**
 * Class Menu
 *
 * @package backend\modules\menu\models\search
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class Menu extends ParentModel implements BaseBackendSearchModel
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
     * Description
     *
     * @param $query
     * @param $params
     * @return ActiveDataProvider
     */
    public function baseSearch($query, $params)
    {
        /** @var ParentModule $module */
        $module = Yii::$app->getModule('menu');
        $dataProvider = new ActiveDataProvider(
            [
                'query' => $query,
                'pagination' => [
                    'defaultPageSize' => $module->itemOnPage
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

        $query->andFilterWhere(['like', 'alias', $this->alias])
            ->andFilterWhere(['=', 'published', $this->published]);
        //
        $query->andFilterWhere(['like', MenuLang::tableName() . '.title', $this->title]);

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
        $query = ParentModel::find()->joinWith(['lang'])->undeleted();
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
        $query = ParentModel::find()->joinWith(['lang'])->deleted();
        return $this->baseSearch($query, $params);
    }
}
