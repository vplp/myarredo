<?php

namespace frontend\components;

use frontend\modules\catalog\Catalog;
use Yii;
use yii\web\Controller;
//
use frontend\modules\sys\models\Language;

/**
 * Class BaseController
 *
 * @package frontend\components
 */
abstract class BaseController extends Controller
{
    /**
     * @var string
     */
    public $layout = "@app/layouts/main";

    /**
     * @var string
     */
    public $defaultAction = 'index';

    /**
     * @var array
     */
    public $breadcrumbs = [];

    public function beforeAction($action)
    {
        if (preg_match('!/{2,}!', $_SERVER['REQUEST_URI'])) {
            $url = preg_replace('!/{2,}!', '/', $_SERVER['REQUEST_URI']);
            header('Location: ' . $url, false, 301);
            exit();
        }

        $this->getAlternateHreflang();

        $this->setCurrency();

        return parent::beforeAction($action);
    }

    /**
     * @inheritdoc
     */
    public function afterAction($action, $result)
    {
        //$this->detectBrowserLanguage();

        return parent::afterAction($action, $result);
    }

    /**
     * @inheritdoc
     */
    protected function setCurrency()
    {
        $session = Yii::$app->session;

        /**
         * Set currency
         */
        $lang = substr(Yii::$app->language, 0, 2);

        if (in_array(Yii::$app->city->domain, ['ua', 'by'])) {
            $session->set('currency', 'EUR');
        } elseif (!$session->has('currency') && $lang == 'ru') {
            $session->set('currency', 'RUB');
        } elseif (!$session->has('currency')) {
            $session->set('currency', 'EUR');
        }
    }

    /**
     * @inheritdoc
     */
    protected function getAlternateHreflang()
    {
        $languages = Language::getAllByLocate();
        $current_url = Yii::$app->request->url;

        foreach ($languages as $alternate) {
            $alternatePages[$alternate['local']] = [
                'href' => Yii::$app->request->hostInfo .
                    ($alternate['alias'] != 'ru' ? '/' . $alternate['alias'] : '') .
                    str_replace('/' . $languages[Yii::$app->language]['alias'], '', $current_url),
                'lang' => substr($alternate['local'], 0, 2),
                'current' => (Yii::$app->language == $alternate['local']) ? true : false
            ];
        }

        if (!empty($alternatePages)) {
            foreach ($alternatePages as $page) {
                Yii::$app->view->registerLinkTag([
                    'rel' => 'alternate',
                    'href' => $page['href'],
                    'hreflang' => $page['lang']
                ]);
            }
            unset($alternatePages);
        }
    }

    /**
     * @inheritdoc
     */
    protected function detectBrowserLanguage()
    {
        /** @var $module Catalog */
        $module = Yii::$app->getModule('catalog');

        if (!$module->isBot1() && !$module->isBot2() && isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
            $session = Yii::$app->session;

            // список языков
            $languages = Language::getAllByLocate();
            $current_url = Yii::$app->request->url;

            $sites = [];

            foreach ($languages as $alternate) {
                $sites[$alternate['alias']] = Yii::$app->request->hostInfo .
                    ($alternate['alias'] != 'ru' ? '/' . $alternate['alias'] : '') .
                    str_replace('/' . $languages[Yii::$app->language]['alias'], '', $current_url);
            }

            // получаем язык
            $lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);

            // перенаправление на субдомен
            if (!$session->has('BrowserLanguage') && in_array($lang, array_keys($sites))) {
                $session->set('BrowserLanguage', $lang);
                header('Location: ' . $sites[$lang]);
                exit();
            } else {
                $session->set('BrowserLanguage', 'ru');
            }
        }
    }
}
