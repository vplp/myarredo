<?php

namespace frontend\modules\seo\controllers;

use Yii;
use yii\web\Controller;

/**
 * Class RobotsController
 *
 * @package frontend\modules\seo\controllers
 */
class RobotsController extends Controller
{
    /**
     * robots.txt
     */
    public function actionIndex()
    {
        echo 'User-agent: *' . PHP_EOL;
        echo 'Disallow: *?view' . PHP_EOL;
        echo 'Disallow: /partner/' . PHP_EOL;
        echo 'Disallow: /*openstat*' . PHP_EOL;
        echo 'Disallow: /*utm*' . PHP_EOL;
        echo 'Disallow: /search/' . PHP_EOL;
        echo 'Disallow: /orders/' . PHP_EOL;
        echo 'Disallow: *three=*' . PHP_EOL;
        echo 'Disallow: *sort=*' . PHP_EOL;
        echo 'Disallow: *object=*' . PHP_EOL;
        echo 'Disallow: *partner=*' . PHP_EOL;
        echo 'Disallow: *?three*' . PHP_EOL;
        echo 'Disallow: /type/' . PHP_EOL;
        echo 'Disallow: /style/' . PHP_EOL;
        echo 'Disallow: *login*' . PHP_EOL;
        echo 'Disallow: *notepad*' . PHP_EOL;
        echo 'Disallow: *=novelty*' . PHP_EOL;
        echo 'Disallow: *=bestseller*' . PHP_EOL;
        echo 'Disallow: /catalog/*?' . PHP_EOL;
        echo 'Disallow: *price=*' . PHP_EOL;
        echo 'Disallow: /user/' . PHP_EOL;
        echo 'Disallow: /shop/' . PHP_EOL;
        echo 'Allow: /catalog/*?page=*' . PHP_EOL . PHP_EOL;

        echo 'User-agent: Yandex' . PHP_EOL;
        echo 'Disallow: *.svg' . PHP_EOL . PHP_EOL;

        echo 'User-agent: Googlebot' . PHP_EOL;
        echo 'Disallow: *.svg' . PHP_EOL;

        echo PHP_EOL . 'Host: https://' . Yii::$app->request->serverName . PHP_EOL;

        $city = Yii::$app->city->getCity();

        if (DOMAIN_TYPE == 'com') {
            echo 'Sitemap: https://' . Yii::$app->request->hostName . '/sitemap/sitemap.xml' . PHP_EOL;
        } else {
            echo 'Sitemap: https://' . Yii::$app->request->hostName . '/sitemap/sitemap_' . $city['alias'] . '.xml' . PHP_EOL;
        }

        $response = Yii::$app->response;
        $response->format = yii\web\Response::FORMAT_RAW;
        $response->headers->set('Content-Type', 'text/plain');

        return $response;
    }
}
