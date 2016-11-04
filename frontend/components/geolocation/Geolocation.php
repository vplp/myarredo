<?php

namespace frontend\components\geolocation;

use Yii;
//
use yii\base\Component;
//
use frontend\modules\configs\models\Language;

/**
 * Class Geolocation
 * @package frontend\components\geolocation
 *
 * @author Andrii Bondarchuk
 * @copyright (c) 2016
 */
class Geolocation extends Component
{
    public $config = ['provider' => NULL, 'return_formats' => NULL, 'api_key' => NULL];

    private static $plugins = array();
    private static $provider = NULL;
    private static $return_formats = NULL;
    private static $api_key = NULL;

    public function __construct($config = array())
    {
        self::$plugins = array_diff(scandir((__DIR__) . '/plugins/'), array('..', '.'));

        if (isset($config['config']['provider'])) {

            $provider = $config['config']['provider'];

            if (in_array($provider . ".php", self::$plugins)) {

                require (__DIR__) . '/plugins/' . $provider . '.php';

                if (isset($config['config']['return_formats'])) {
                    $format = $config['config']['return_formats'];

                    if (in_array($format, $plugin['accepted_formats'])) {
                        self::$return_formats = $format;
                    } else {
                        self::$return_formats = $plugin['default_accepted_format'];
                    }
                }

                self::$provider = $plugin;

                self::$api_key = (isset($config['config']['api_key'])) ? $config['config']['api_key'] : NULL;

            } else {
                throw new \yii\web\HttpException(404, 'The requested Item could not be found.');
            }
        } else {
            require (__DIR__) . '/plugins/geoplugin.php';
            self::$provider = $plugin;
            self::$return_formats = $plugin['default_accepted_format'];
        }

        return parent::__construct($config);
    }

    /**
     * Creates the plugin URL
     *
     * @param string $ip
     * @return string
     */
    private static function createUrl($ip)
    {
        $urlTmp = preg_replace('!\{\{(accepted_formats)\}\}!', self::$return_formats, self::$provider['plugin_url']);
        $urlTmp = preg_replace('!\{\{(ip)\}\}!', $ip, $urlTmp);

        if (isset(self::$api_key))
            $urlTmp = preg_replace('!\{\{(api_key)\}\}!', self::$api_key, $urlTmp);

        return $urlTmp;
    }

    /**
     * Returns client info
     *
     * @param string $ip You can supply an IP address or none to use the current client IP address
     * @return mixed
     */
    public static function getInfo($ip = NULL)
    {
        if (!isset($ip))
            $ip = self::getIP();

        $url = self::createUrl($ip);

        //print_r($url); exit;

        if (self::$return_formats == 'php')
            return unserialize(file_get_contents($url));
        else
            return file_get_contents($url);
    }

    /**
     * Changes the used plugin
     *
     * @param string $provider The provider plugin name
     * @param string $format The data return format
     */
    public static function getPlugin($provider = NULL, $format = NULL, $api_key = NULL)
    {
        self::$plugins = array_diff(scandir((__DIR__) . '/plugins/'), array('..', '.'));

        if (isset($api_key)) {
            self::$api_key = $api_key;
        }


        if (in_array($provider . ".php", self::$plugins)) {

            require (__DIR__) . '/plugins/' . $provider . '.php';

            if (in_array($format, $plugin['accepted_formats'])) {
                self::$return_formats = $format;
            } else {
                self::$return_formats = $plugin['default_accepted_format'];
            }

            self::$provider = $plugin;
        }

    }

    /**
     * Returns ip
     *
     * @return string
     */
    private static function getIP()
    {
        $ip = getenv('HTTP_CLIENT_IP') ?:
            getenv('HTTP_X_FORWARDED_FOR') ?:
                getenv('HTTP_X_FORWARDED') ?:
                    getenv('HTTP_FORWARDED_FOR') ?:
                        getenv('HTTP_FORWARDED') ?:
                            getenv('REMOTE_ADDR');
        return $ip;
    }

    /**
     * Returns browser language
     *
     * @return string
     */
    public static function getBrowserLanguage()
    {
        return substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
    }

    /**
     * Set lang for user from it browser
     */
    public function redirectOnBrowserLanguage()
    {
        // check if isset cookie userLang
        if (!isset(Yii::$app->request->cookies['userLang'])) {

            // catch current lang from url
            $url = explode("/", substr($_SERVER["REQUEST_URI"], 1));

            // check if lang is in database
            if (Language::getDefaultByUrl($url[0])) {

                // get lang from browser
                if ($lang = self::getBrowserLanguage()) {

                    // check if isset lang in database
                    if ($userLang = Language::getByAlias($lang)) {

                        // set cookie userLang
                        Yii::$app->response->cookies->add(new \yii\web\Cookie([
                            'name' => 'userLang',
                            'value' => 1
                        ]));

                        // check if userLang is default
                        if ($userLang['default'] != 1) {

                            //redirect user to page with his lang
                            $url = "http://{$_SERVER['HTTP_HOST']}/{$userLang['alias']}{$_SERVER['REQUEST_URI']}";

                            return \Yii::$app->getResponse()->redirect($url);
                        }
                    }
                }
            }
        }
    }
}
