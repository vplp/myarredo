<?php

namespace frontend\modules\articles\widgets\articles;

use Yii;
use yii\base\Widget;
use frontend\modules\articles\models\{
    Article, ArticleLang
};

/**
 * Class ArticlesList
 *
 * @package frontend\modules\articles\widgets\articles
 */
class ArticlesList extends Widget
{
    /**
     * @var string
     */
    public $view = 'articles_list';

    /**
     * @var int
     */
    public $limit = 3;

    /**
     * @var object
     */
    protected $model = [];

    /**
     * @var int
     */
    public $category_id = 0;

    /**
     * @var int
     */
    public $city_id = 0;

    /**
     * Init model for run method
     */
    public function init()
    {
        $query = Article::findBase()
            ->select([
                Article::tableName() . '.id',
                Article::tableName() . '.alias',
                Article::tableName() . '.image_link',
                Article::tableName() . '.published_time',
                Article::tableName() . '.updated_at',
                ArticleLang::tableName() . '.title',
                ArticleLang::tableName() . '.description',
            ])
            ->limit($this->limit);

        if ($alias = Yii::$app->request->get('alias')) {
            $query->andFilterWhere(['<>', 'alias', $alias]);
        }

        if ($this->category_id) {
            $query->andFilterWhere(['=', 'category_id', $this->category_id]);
        }

        if ($this->city_id) {
            $query->andFilterWhere(['=', 'city_id', $this->city_id]);
        }

        $this->model = $query->all();
    }

    /**
     * @return string
     */
    public function run()
    {
        return $this->render(
            $this->view,
            [
                'articles' => $this->model
            ]
        );
    }
}
