<?php

namespace frontend\modules\catalog\models;

use Yii;

/**
 * Class SaleStats
 *
 * @package frontend\modules\catalog\models
 */
class SaleStats extends \common\modules\catalog\models\SaleStats
{
    public static function create($sale_item_id)
    {
        $model = new self();

        $model->setScenario('frontend');

        $model->user_id = Yii::$app->getUser()->id ?? 0;
        $model->sale_item_id = $sale_item_id;
        $model->country_id = Yii::$app->city->getCountryId();
        $model->city_id = Yii::$app->city->getCityId();
        $model->date = mktime(0, 0, 0, date("m"), date("d"), date("Y"));
        $model->ip = Yii::$app->request->userIP;
        $model->http_user_agent = $_SERVER['HTTP_USER_AGENT'];
        $model->is_bot = self::isBot2();

        $model->save();
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
