<?php

namespace frontend\modules\catalog\widgets\paginator;

use Yii;
use yii\base\Widget;

/**
 * Class PageChanger
 *
 * @package frontend\modules\catalog\widgets\paginator
 */
class PageChanger extends Widget
{
    public $pages;

    /**
     * @return string
     */
    public function run()
    {
        $pageArray = Yii::$app->request->get();

        return $this->render(
            'pageChanger',
            [
                'pages' => $this->pages,
                'pageArray' => $pageArray
            ]
        );
    }
}