<?php

namespace frontend\modules\news\widgets\news;

use yii\base\Widget;
//
use frontend\modules\news\models\ArticleForPartners;

/**
 * Class NewsListForPartners
 *
 * @package frontend\modules\news\widgets\news
 */
class NewsListForPartners extends Widget
{
    /**
     * @var string
     */
    public $view = 'news_list_for_partners';

    /**
     * @var object
     */
    protected $model = [];

    /**
     * Init model for run method
     */
    public function init()
    {
        $this->model = ArticleForPartners::findBase()->limit(3)->all();
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