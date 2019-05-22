<?php

namespace frontend\modules\articles\widgets\articles;

use yii\base\Widget;
//
use frontend\modules\articles\models\Article;

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
        $this->model = Article::findBase()
            ->limit($this->limit)
            ->all();
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