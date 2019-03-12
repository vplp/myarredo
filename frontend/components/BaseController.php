<?php

namespace frontend\components;

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

        return parent::beforeAction($action);
    }

    /**
     * @inheritdoc
     */
    protected function getAlternateHreflang()
    {
        $languages = Language::getAllByLocate();
        $current_url = Yii::$app->request->pathInfo;

        foreach ($languages as $alternate) {
            if (Yii::$app->language != $alternate['local']) {
                $alternatePages[$alternate['local']] = [
                    'href' => Yii::$app->request->hostInfo .
                        ($alternate['alias'] != 'ru' ? '/' . $alternate['alias'] : '') . '/' .
                        str_replace('/' . $languages[Yii::$app->language]['alias'], '', $current_url),
                    'lang' => substr($alternate['local'], 0, 2),
                    'current' => (Yii::$app->language == $alternate['local']) ? true : false
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
