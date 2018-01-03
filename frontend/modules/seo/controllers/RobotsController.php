<?php

namespace frontend\modules\seo\controllers;

use Yii;
use frontend\components\BaseController;

/**
 * Class RobotsController
 *
 * @package frontend\modules\seo\controllers
 */
class RobotsController extends BaseController
{
    /**
     * Перезаписуем robots.txt
     * @return string
     */
    public function actionIndex()
    {

        die;
        echo 'User-agent: *' . PHP_EOL;
        echo 'Disallow: /admin/' . PHP_EOL;
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

//        $server = Yii::app()->getRequest()->getServerName();
//
//        $name = ($this->subdomain) ? $this->subdomain : $this->domain;
//
//        echo PHP_EOL . 'Host: ' . $server . PHP_EOL;
//        echo 'Sitemap: http://' . $server . '/sitemap/sitemap_' . $name . '.xml' . PHP_EOL;


        die;
    }
}
