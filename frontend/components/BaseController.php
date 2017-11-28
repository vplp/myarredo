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

    protected $directlink;

    public function init()
    {

        $this->directlink = Directlink::findByUrl();

        parent::init();
    }

    /**
     * @param \yii\base\Action $action
     * @return bool|\yii\web\Response
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
        $h1 = false;

        if ($this->directlink['h1']) {
            $h1 = str_replace('#городе#', Yii::$app->city->getCityTitleWhere(), $this->directlink['h1']);
        }

        return $h1;
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
