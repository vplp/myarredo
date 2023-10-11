<?php

namespace backend\modules\polls\models\search;

use Yii;
use yii\data\ActiveDataProvider;
use yii\base\Model;
//
use thread\app\model\interfaces\search\BaseBackendSearchModel;
//
use backend\modules\polls\Polls as PollsModule;
use backend\modules\polls\models\{
    Vote as VoteModel, VoteLang
};

/**
 * Class Vote
 *
 * @package backend\modules\polls\models\search
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class Vote extends VoteModel implements BaseBackendSearchModel
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
     * @param $query
     * @param $params
     * @return ActiveDataProvider
     */
    public function baseSearch($query, $params)
    {
        /** @var PollsModule $module */
        $module = Yii::$app->getModule('polls');
        $dataProvider = new ActiveDataProvider(
            [
                'query' => $query,
                'pagination' => [
                    'defaultPageSize' => $module->itemOnPage
                ],
                'sort' => [
                    'defaultOrder' => [
                        'position' => SORT_ASC
                    ]
                ]
            ]
        );

        $query->andWhere(['group_id' => Yii::$app->getRequest()->get('group_id') ?? '']);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }
        $query->andFilterWhere(['=', 'published', $this->published]);
        //
        $query->andFilterWhere(['like', VoteLang::tableName() . '.title', $this->title]);

        return $dataProvider;
    }

    /**
     * Description
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = VoteModel::find()->joinWith(['lang'])->undeleted();
        return $this->baseSearch($query, $params);
    }

    /**
     * Description
     * @param $params
     * @return ActiveDataProvider
     */
    public function trash($params)
    {
        $query = VoteModel::find()->joinWith(['lang'])->deleted();
        return $this->baseSearch($query, $params);
    }
}
