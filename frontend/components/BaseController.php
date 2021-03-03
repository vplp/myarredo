<?php

namespace frontend\components;

use Yii;
use yii\helpers\Url;
use yii\web\Controller;
use frontend\modules\catalog\Catalog;
use frontend\modules\seo\models\Redirects;
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


    /**
     * @var bool
     */
    public $noIndex = false;

    /**
     * @param \yii\base\Action $action
     * @return bool
     * @throws \yii\base\ExitException
     * @throws \yii\web\BadRequestHttpException
     */
    public function beforeAction($action)
    {

        // переход к ответу на заявку при авторизации на сайте
        $session = Yii::$app->session;

        if (Yii::$app->getUser()->isGuest && !$session->has('redirectToOrders') && strripos(Yii::$app->request->url, '/orders/')) {
            $session->set('redirectToOrders', Yii::$app->request->url);
        } else if (!Yii::$app->getUser()->isGuest && $session->has('redirectToOrders')) {
            $session->remove('redirectToOrders');
        }

        Redirects::findRedirect();

        $lang = substr(Yii::$app->language, 0, 2);

        // il domain
        if (!in_array(@$_SERVER['REMOTE_ADDR'], ['127.0.0.1', '::1']) && DOMAIN_TYPE == 'co.il' && !in_array($lang, ['he'])) {
            Yii::$app->response->redirect('https://' . 'www.myarredo.co.il/', 301);
            yii::$app->end();
        } elseif (!in_array(@$_SERVER['REMOTE_ADDR'], ['127.0.0.1', '::1']) && in_array(DOMAIN_TYPE, ['ru', 'ua', 'by', 'com', 'de']) && in_array($lang, ['he'])) {
            Yii::$app->response->redirect('https://' . 'www.myarredo.co.il/', 301);
            yii::$app->end();
        }

        // de domain
        if (!in_array(@$_SERVER['REMOTE_ADDR'], ['127.0.0.1', '::1']) && DOMAIN_TYPE == 'de' && !in_array($lang, ['de'])) {
            Yii::$app->response->redirect('https://' . 'www.myarredo.de/', 301);
            yii::$app->end();
        } elseif (!in_array(@$_SERVER['REMOTE_ADDR'], ['127.0.0.1', '::1']) && in_array(DOMAIN_TYPE, ['ru', 'ua', 'by', 'com']) && in_array($lang, ['de'])) {
            Yii::$app->response->redirect('https://' . 'www.myarredo.de/', 301);
            yii::$app->end();
        }

        // com domain
        if (!in_array(@$_SERVER['REMOTE_ADDR'], ['127.0.0.1', '::1']) && DOMAIN_TYPE == 'com' && !in_array($lang, ['it', 'en'])) {
            Yii::$app->response->redirect('https://' . 'www.myarredo.com/it/', 301);
            yii::$app->end();
        } elseif (!in_array(@$_SERVER['REMOTE_ADDR'], ['127.0.0.1', '::1']) && in_array(DOMAIN_TYPE, ['ru', 'ua', 'by', 'de']) && in_array($lang, ['it', 'en'])) {
            Yii::$app->response->redirect('https://' . 'www.myarredo.com/it/', 301);
            yii::$app->end();
        }

        // ua domain
        if (!in_array(@$_SERVER['REMOTE_ADDR'], ['127.0.0.1', '::1']) && DOMAIN_TYPE != 'ua' && in_array($lang, ['uk'])) {
            Yii::$app->response->redirect('https://' . 'www.myarredo.ua/ua/', 301);
            yii::$app->end();
        }

        if (preg_match('!/{2,}!', $_SERVER['REQUEST_URI'])) {
            $url = preg_replace('!/{2,}!', '/', $_SERVER['REQUEST_URI']);
            header('Location: ' . $url, false, 301);
            exit();
        }

        $this->getAlternateHreflang();

        $this->setCurrency();

        Yii::$app->response->headers->set('Expires', gmdate('D, d M Y H:i:s \G\M\T', time() + 86400));
        Yii::$app->response->headers->set('Vary', 'User-Agent');

        return parent::beforeAction($action);
    }

    /**
     * @inheritdoc
     */
    public function afterAction($action, $result)
    {
        //$this->detectBrowserLanguage();

        $session = Yii::$app->session;

        if ($session->get('referrer') != Url::current([], true)) {
            $session->set('referrer', Yii::$app->request->referrer);
        } else {
            $session->set('referrer', Url::toRoute('/user/profile/index'));
        }

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

        if (in_array(DOMAIN_TYPE, ['ua', 'by', 'com', 'de', 'he'])) {
            $session->set('currency', 'EUR');
        } elseif (in_array(DOMAIN_TYPE, ['kz'])) {
            $session->set('currency', 'KZT');
        } elseif (in_array(DOMAIN_TYPE, ['co.il'])) {
            $session->set('currency', 'ILS');
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
        if (Yii::$app->controller->action->id != 'error' &&
            !in_array(Yii::$app->controller->id, ['articles', 'contacts', 'category', 'product', 'sale-italy', 'sale']) &&
            in_array(Yii::$app->city->getCityId(), [4, 159, 160, 161]) &&
            !in_array(Yii::$app->controller->module->id, ['news'])
        ) {
            $languages = Language::getAllByLocate();
            $current_url = Yii::$app->request->url;

            foreach ($languages as $item) {
                $lang = substr($item['local'], 0, 2);
                $href = str_replace(
                    '/' . $languages[Yii::$app->language]['alias'],
                    '',
                    $current_url
                );

                if ($item['alias'] == 'he') {
                    continue;
                }

                if (in_array(DOMAIN_TYPE, ['com', 'de', 'ru']) && in_array($item['alias'], ['it', 'en'])) {
                    $alternatePages[$item['local']] = [
                        'href' => 'https://www.myarredo.com' . '/' . $item['alias'] . $href,
                        'lang' => $lang
                    ];
                } elseif (in_array(DOMAIN_TYPE, ['com', 'de', 'ru']) && in_array($item['alias'], ['de'])) {
                    $alternatePages[$item['local']] = [
                        'href' => 'https://www.myarredo.de' . $href,
                        'lang' => $lang
                    ];
                } elseif (in_array(DOMAIN_TYPE, ['com', 'de', 'ru']) && in_array($item['alias'], ['ru'])) {
                    $alternatePages[$item['local']] = [
                        'href' => 'https://www.myarredo.ru' . $href,
                        'lang' => $lang
                    ];
                }
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
