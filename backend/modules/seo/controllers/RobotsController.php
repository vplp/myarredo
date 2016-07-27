<?php
namespace backend\modules\seo\controllers;

use thread\app\base\controllers\BackendController;
use Yii;

/**
 * Class RobotsController
 * @package backend\modules\seo\controllers
 */
class RobotsController extends BackendController
{
    public $title = 'Robots.txt';

    /**
     * @return array
     */
    public function actions()
    {
        return [];
    }


    /**
     * Перезаписуем robots.txt
     * @return string
     */
    public function actionUpdate()
    {
        $robotsTextPath = Yii::getAlias('@frontend-web').'/robots.txt';

        $post = Yii::$app->getRequest()->post('robots');
        if ($post) {
            file_put_contents($robotsTextPath, $post);
        }

        if (! file_exists($robotsTextPath)) {
            fopen($robotsTextPath, 'w+');
        }
        $robotsTxt = file_get_contents($robotsTextPath);


        return $this->render('_form', ['robotsTxt' => $robotsTxt]);
    }
}
