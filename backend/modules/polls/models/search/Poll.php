<?php
namespace backend\modules\polls\models\search;

use Yii;
use yii\data\ActiveDataProvider;
use yii\base\Model;
//
use thread\app\base\models\query\ActiveQuery;
use thread\app\model\interfaces\search\BaseBackendSearchModel;
//
use backend\modules\polls\Polls as PollsModule;
use backend\modules\polls\models\{
    Poll as PollModel, PollLang
};

/**
 * Class Group
 *
 * @package backend\modules\polls\models\search
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class Poll extends PollModel implements BaseBackendSearchModel
{
    public $title, $start_date_from, $start_date_to, $finish_date_from, $finish_date_to;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['title'], 'string', 'max' => 255],
            [['published'], 'in', 'range' => array_keys(self::statusKeyRange())],
            [
                ['start_time'],
                'date',
                'format' => 'php:' . PollsModule::getFormatDate(),
                'timestampAttribute' => 'start_time'
            ],
            [
                ['start_date_from'],
                'date',
                'format' => 'php:' . PollsModule::getFormatDate(),
                'timestampAttribute' => 'start_date_from'
            ],
            [
                ['start_date_to'],
                'date',
                'format' => 'php:' . PollsModule::getFormatDate(),
                'timestampAttribute' => 'start_date_to'
            ],
            [
                ['finish_time'],
                'date',
                'format' => 'php:' . PollsModule::getFormatDate(),
                'timestampAttribute' => 'finish_time'
            ],
            [
                ['finish_date_from'],
                'date',
                'format' => 'php:' . PollsModule::getFormatDate(),
                'timestampAttribute' => 'finish_date_from'
            ],
            [
                ['finish_date_to'],
                'date',
                'format' => 'php:' . PollsModule::getFormatDate(),
                'timestampAttribute' => 'finish_date_to'
            ],
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
        /** @var PollsModule $module */
        $module = Yii::$app->getModule('polls');
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'defaultPageSize' => $module->itemOnPage
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

        $query->andFilterWhere(['=', 'published', $this->published])
            ->andFilterWhere(['like', 'published_time', $this->start_time])
            ->andFilterWhere(['like', 'published_time', $this->finish_time]);
        //
        $query->andFilterWhere(['>=', 'start_time', $this->start_date_from]);
        $query->andFilterWhere(['<=', 'start_time', $this->start_date_to]);
        //
        $query->andFilterWhere(['>=', 'finish_time', $this->finish_date_from]);
        $query->andFilterWhere(['<=', 'finish_time', $this->finish_date_to]);
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
        $query = PollModel::find()->joinWith(['lang'])->undeleted();
        return $this->baseSearch($query, $params);
    }

    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function trash($params)
    {
        $query = PollModel::find()->joinWith(['lang'])->deleted();
        return $this->baseSearch($query, $params);
    }
}
