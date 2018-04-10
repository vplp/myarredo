<?php

namespace frontend\modules\catalog\models;

use Yii;

/**
 * Class ProductStats
 *
 * @package frontend\modules\catalog\models
 */
class ProductStats extends \common\modules\catalog\models\ProductStats
{
    public static function create($product_id)
    {
        $model = new self();

        $model->setScenario('frontend');

        $model->user_id = Yii::$app->getUser()->id ?? 0;
        $model->ip = Yii::$app->request->userIP;
        $model->is_bot = self::isBot2();
        $model->http_user_agent = $_SERVER['HTTP_USER_AGENT'];
        $model->city_id = Yii::$app->city->getCityId();
        $model->product_id = $product_id;

        $model->save();
    }

    /**
     * @param $params
     * @return mixed
     */
    public function search($params)
    {
        return (new search\ProductStats())->search($params);
    }

    /**
     * Проверяет, является ли посетитель роботом поисковой системы из перечня.
     *
     * @param string $bot_name
     * @return bool|string
     */
    public static function isBot1(&$bot_name = '')
    {
        $bots = array(
            'rambler', 'googlebot', 'aport', 'yahoo', 'msnbot', 'turtle', 'mail.ru', 'omsktele',
            'yetibot', 'picsearch', 'sape.bot', 'sape_context', 'gigabot', 'snapbot', 'alexa.com',
            'megadownload.net', 'askpeter.info', 'igde.ru', 'ask.com', 'qwartabot', 'yanga.co.uk',
            'scoutjet', 'similarpages', 'oozbot', 'shrinktheweb.com', 'aboutusbot', 'followsite.com',
            'dataparksearch', 'google-sitemaps', 'appEngine-google', 'feedfetcher-google',
            'liveinternet.ru', 'xml-sitemaps.com', 'agama', 'metadatalabs.com', 'h1.hrn.ru',
            'googlealert.com', 'seo-rus.com', 'yaDirectBot', 'yandeG', 'yandex',
            'yandexSomething', 'Copyscape.com', 'AdsBot-Google', 'domaintools.com',
            'Nigma.ru', 'bing.com', 'dotnetdotcom'
        );
        foreach ($bots as $bot) {
            if (stripos($_SERVER['HTTP_USER_AGENT'], $bot) !== false) {
                $bot_name = $bot;
                return $bot_name;
            }
        }
        return false;
    }

    /**
     * Альтернативный метод проверки на бота
     */
    public static function isBot2()
    {
        $is_bot = preg_match(
            "~(Google|Yahoo|Rambler|Bot|Yandex|Spider|Snoopy|Crawler|Finder|Mail|curl)~i",
            $_SERVER['HTTP_USER_AGENT']
        );
        return $is_bot;
    }
}
