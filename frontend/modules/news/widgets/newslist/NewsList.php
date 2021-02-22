<?php

namespace frontend\modules\news\widgets\newslist;

use Yii;
use yii\base\Widget;
use frontend\modules\news\models\{
    Article, ArticleLang
};

/**
 * Class NewsList
 *
 * @package frontend\modules\news\widgets\newslist
 */
class NewsList extends Widget
{
    /**
     * @var string
     */
    public $view = 'news_list';

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
                Article::tableName() . '.published_time',
                Article::tableName() . '.updated_at',
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
