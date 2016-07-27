<?php
namespace backend\modules\news\models\search;

use backend\modules\news\News as NewsModule;
use thread\app\base\models\query\ActiveQuery;
use Yii;
use yii\data\ActiveDataProvider;
use backend\modules\news\models\Article as ArticleModel;

class Article extends ArticleModel
{
    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['group_id', 'created_at', 'updated_at'], 'integer'],
            [['published_time'], 'date', 'format' => 'php:' . Yii::$app->modules['news']->params['format']['date'], 'timestampAttribute' => 'published_time'],

            [['alias', 'image_link'], 'string', 'max' => 255],
            [['alias'], 'unique'],
        ];
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

        $query->joinWith(['lang', 'group']);

        $query->andFilterWhere([
            'id' => $this->id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);


        return $dataProvider;
    }

    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = ArticleModel::find()->with(['lang'])->undeleted();
        return $this->baseSearch($query, $params);
    }

    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function trash($params)
    {
        $query = ArticleModel::find()->with(['lang'])->deleted();
        return $this->baseSearch($query, $params);
    }
}
