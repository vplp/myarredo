<?php

namespace frontend\components;

use Yii;
//
use yii\helpers\Url;
use yii\web\Controller;
//
use frontend\modules\seo\modules\{
    directlink\models\Directlink
};

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
    public $pageH1 = '';

    protected $directlink;

    public function init()
    {
        $this->directlink = Directlink::findByUrl();

        /**
         * Set user interface language
         */
        if (!Yii::$app->getUser()->isGuest) {
            /** @var User $user */
            $user = Yii::$app->getUser()->getIdentity();
            Yii::$app->params['themes']['language'] = $user->profile->preferred_language;
            Yii::$app->language = $user->profile->preferred_language;
        }

        parent::init();
    }

    /**
     * @param $action
     * @return bool|\yii\web\Response
     * @throws \yii\web\BadRequestHttpException
     */
    public function beforeAction($action)
    {
        $searchCondition = \Yii::$app->getRequest()->get('search', null);

        if ($searchCondition) {
            return $this->redirect(Url::to(['/page/find/index', 'condition' => $searchCondition]));
        }

        return parent::beforeAction($action);
    }

    /**
     * @return string
     */
    public function getSeoH1()
    {
        if ($this->directlink['h1']) {
            $this->pageH1 = str_replace('#городе#', Yii::$app->city->getCityTitleWhere(), $this->directlink['h1']);
        }

        return $this->pageH1;
    }

    /**
     * @return string
     */
    public function getSeoContent()
    {
        $content = false;

        if ($this->directlink['content']) {
            $content = str_replace('#городе#', Yii::$app->city->getCityTitleWhere(), $this->directlink['content']);
        }

        return $content;
    }
}
