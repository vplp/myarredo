<?php
namespace thread\app\web;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\StringHelper;
use thread\app\web\interfaces\InjectionLanguage as iInjectionLanguage;

/**
 * class MultiLanguage
 *
 * 'urlManager' => [
 *       'bases' => [
 *          [
 *              'folder' => 'new_folder',
 *              'alias' => 'new_folder',
 *          ],
 *       ]
 *  ],
 *
 *
 *
 * @package thread\components
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class InjectionLanguage implements iInjectionLanguage
{
    const KEY_ON = 1;
    const KEY_OFF = 0;
//
    public static $multi = 1;
    public static $show_default = 0;
    /**
     * @var array
     */
    public static $bases = [
        [
            'folder' => 'backend',
            'alias' => 'backend',
        ],
//        [
//            'folder' => 'frontend',
//            'alias' => '',
//        ],
        [
            'folder' => 'web',
            'alias' => '',
        ],
    ];
//
    /**
     * @var
     */
    protected static $domains;
    /**
     * @var string
     */
    protected static $baseFolder = '';
    /**
     * @var string
     */
    protected static $homeUrl = '';

    /**
     * @param string $url
     * @return mixed
     */
    protected static function setDomains(string $url):array
    {
        self::$baseFolder = '';

        if (empty(self::$homeUrl)) {
            self::$homeUrl = rtrim(StringHelper::dirname($_SERVER['PHP_SELF']), '/');
        }

        if (empty(self::$baseFolder)) {

            foreach (self::$bases as $base) {
                if ($str = mb_stristr(self::$homeUrl, $base['folder'], true)) {
                    self::$baseFolder = $str . $base['alias'];
                    break;
                }
            }

            if ($str == false && !empty(self::$homeUrl)) {
                self::$baseFolder = rtrim(self::$homeUrl, '/');
            }

            self::$baseFolder = rtrim(self::$baseFolder, '/');
        }
//
        $url = StringHelper::byteSubstr($url, StringHelper::byteLength(self::$baseFolder),
            StringHelper::byteLength($url));
        self::$domains = explode('/', ltrim($url, '/'));
//

        return self::$domains;
    }

    /**
     * @param string $url
     * @return string
     */
    public static function processLangInUrl(string $url):string
    {

        if (self::$multi) {
            $domains = self::setDomains($url);
//
            $lang = Yii::$app->languages;
//
            $exists = (isset($domains[0])) ? $lang->isExistsByAlias($domains[0]) : false;
            $isDefault = ($lang->getDefault()['alias'] == $domains[0]) ? true : false;

            if ($exists && !$isDefault) {
                $lang = $lang->getLangByAlias($domains[0]);
                Yii::$app->language = $lang['local'];
                array_shift($domains);
            } elseif ($isDefault && self::$show_default) {
                array_shift($domains);
            }

            $d = (!empty($domains)) ? '/' . implode('/', $domains) : '';

            return self::$homeUrl . $d;
        } else {
            return $url;
        }
    }

    /**
     * @param string $url
     * @return string
     */
    public static function addLangToUrl(string $url):string
    {

        if (self::$multi) {
            $domains = self::setDomains($url);
//
            $lang = Yii::$app->languages;
//
            $exists = (isset($domains[0])) ? $lang->isExistsByAlias($domains[0]) : false;
            $isDefault = (Yii::$app->language === $lang->getDefault()['local'] && self::$show_default === self::KEY_OFF) ? true : false;

            if ($exists && $isDefault && self::$show_default == self::KEY_OFF) {
                array_shift($domains);
            }
//
            if (!$exists && !$isDefault) {
                $lang = $lang->getLangByLocal(Yii::$app->language);
                array_unshift($domains, $lang['alias']);
            }
            $d = (!empty($domains)) ? '/' . implode('/', $domains) : '';
//
            return self::$baseFolder . $d;
        } else {
            return $url;
        }
    }

    /**
     * @return string
     */
    public static function getBaseUrl()
    {
        return self::$baseFolder;
    }

    /**
     * Добавляем новые деректории
     * @param array $bases
     */
    public static function setBases(array $bases)
    {
        self::$bases = ArrayHelper::merge($bases, self::$bases);
    }

}
