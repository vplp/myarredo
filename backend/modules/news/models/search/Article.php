<?php

namespace backend\modules\news\models\search;

use Yii;
use yii\data\ActiveDataProvider;
use yii\base\Model;
//
use thread\app\base\models\query\ActiveQuery;
use thread\app\model\interfaces\search\BaseBackendSearchModel;
//
use backend\modules\news\News as NewsModule;
use backend\modules\news\models\{
    Article as ArticleModel, ArticleLang
};

/**
 * Class Article
 *
 * @package backend\modules\news\models\search
 */
class Article extends ArticleModel implements BaseBackendSearchModel
{
    public $title;
    public $date_from;
    public $date_to;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['alias', 'title'], 'string', 'max' => 255],
            [['published'], 'in', 'range' => array_keys(self::statusKeyRange())],
            [['group_id'], 'integer'],
            [
                ['published_time'],
                'date',
                'format' => 'php:' . NewsModule::getFormatDate(),
                'timestampAttribute' => 'published_time'
            ],
            [
                ['date_from'],
                'date',
                'format' => 'php:' . NewsModule::getFormatDate(),
                'timestampAttribute' => 'date_from'
            ],
            [
                ['date_to'],
                'date',
                'format' => 'php:' . NewsModule::getFormatDate(),
                'timestampAttribute' => 'date_to'
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
        /** @var NewsModule $module */
        $module = Yii::$app->getModule('news');
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'defaultPageSize' => $module->itemOnPage
            ],
            'sort' => [
                'defaultOrder' => [
                    'published_time' => SORT_DESC
                ]
            ]
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->with(['group', 'group.lang']);

        $query->andFilterWhere(['like', 'alias', $this->alias])
            ->andFilterWhere(['=', 'published', $this->published])
            ->andFilterWhere(['like', 'published_time', $this->published_time])
            ->andFilterWhere(['like', 'group_id', $this->group_id]);
        //
        $query->andFilterWhere(['>=', 'published_time', $this->date_from]);
        $query->andFilterWhere(['<=', 'published_time', $this->date_to]);
        //
        $query->andFilterWhere(['like', ArticleLang::tableName() . '.title', $this->title]);

        return $dataProvider;
    }

    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = ArticleModel::find()->joinWith(['lang'])->undeleted();
        return $this->baseSearch($query, $params);
    }

    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function trash($params)
    {
        $query = ArticleModel::find()->joinWith(['lang'])->deleted();
        return $this->baseSearch($query, $params);
    }
}
