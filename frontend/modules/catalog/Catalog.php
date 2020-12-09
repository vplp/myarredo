<?php

namespace frontend\modules\catalog;

use Yii;
use yii\web\Cookie;

/**
 * Class Catalog
 *
 * @package frontend\modules\catalog
 */
class Catalog extends \common\modules\catalog\Catalog
{
    /**
     * @var int
     */
    public $itemOnPage = 24;

    /**
     * Проверяет, является ли посетитель роботом поисковой системы из перечня.
     *
     * @param string $bot_name
     * @return bool|string
     */
    public function isBot1(&$bot_name = '')
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
            'Nigma.ru', 'bing.com', 'dotnetdotcom', 'exensa.com', 'ia_archiver', 'ltx71.com'
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
    public function isBot2()
    {
        $is_bot = preg_match(
            "~(Google|Yahoo|Rambler|Bot|Yandex|Spider|Snoopy|Crawler|Finder|Mail|curl)~i",
            $_SERVER['HTTP_USER_AGENT']
        );

        return $is_bot;
    }

    /**
     * Viewed products
     *
     * @param int $ID
     * @param string $cookieName
     */
    public function getViewedProducts($ID, $cookieName)
    {
        if (!isset(Yii::$app->request->cookies[$cookieName])) {
            Yii::$app->response->cookies->add(new Cookie([
                'name' => $cookieName,
                'domain' => '.' . DOMAIN_NAME . '.' . DOMAIN_TYPE,
                'path' => '/',
                'value' => serialize([$ID]),
                'expire' => time() + 86400 * 7,
            ]));
        } else {
            $viewed = unserialize(Yii::$app->request->cookies->getValue($cookieName));

            if (!in_array($ID, $viewed) && count($viewed) == 12) {
                $viewed = array_slice($viewed, 1, count($viewed));
                $viewed[] = $ID;
            } elseif (!in_array($ID, $viewed)) {
                $viewed[] = $ID;
            }

            $viewed = serialize($viewed);

            Yii::$app->response->cookies->add(new Cookie([
                'name' => $cookieName,
                'domain' => '.' . DOMAIN_NAME . '.' . DOMAIN_TYPE,
                'path' => '/',
                'value' => $viewed,
                'expire' => time() + 86400 * 7,
            ]));
        }
    }
}
