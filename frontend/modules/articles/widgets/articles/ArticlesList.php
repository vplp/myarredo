<?php

namespace frontend\modules\articles\widgets\articles;

use Yii;
use yii\base\Widget;
//
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
     * Init model for run method
     */
    public function init()
    {
        $query = Article::findBase()
            ->select([
                Article::tableName() . '.id',
                Article::tableName() . '.alias',
                Article::tableName() . '.image_link',
                ArticleLang::tableName() . '.title',
                ArticleLang::tableName() . '.description',
            ])
            ->limit($this->limit);

        if ($alias = Yii::$app->request->get('alias')) {
            $query->andFilterWhere(['<>', 'alias', $alias]);
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