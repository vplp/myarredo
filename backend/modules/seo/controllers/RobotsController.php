<?php

namespace backend\modules\seo\controllers;

use Yii;
use thread\app\base\controllers\BackendController;
use yii\filters\AccessControl;

/**
 * Class RobotsController
 *
 * @package backend\modules\seo\controllers
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class RobotsController extends BackendController
{
    public $title = 'Robots.txt';
    public $name = 'Robots.txt';
    public $defaultAction = 'update';

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'AccessControl' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['error'],
                        'roles' => ['?', '@'],
                    ],
                    [
                        'allow' => true,
                        'roles' => ['admin', 'seo'],
                    ],
                    [
                        'allow' => false,
                    ],
                ],
            ],
        ];
    }

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
        $robotsTextPath = Yii::getAlias('@frontend-web') . '/robots.txt';

        $post = Yii::$app->getRequest()->post('robots');
        if ($post) {
            file_put_contents($robotsTextPath, $post);
        }

        if (!file_exists($robotsTextPath)) {
            fopen($robotsTextPath, 'w+');
        }
        $robotsTxt = file_get_contents($robotsTextPath);


        return $this->render('_form', ['robotsTxt' => $robotsTxt]);
    }
}
