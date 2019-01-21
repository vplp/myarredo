<?php

namespace frontend\components;

use Yii;
use yii\web\Controller;
//
use frontend\modules\seo\modules\directlink\models\Directlink;

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

    protected $directLink;

    public function init()
    {
        $this->directLink = Directlink::getInfo();

        parent::init();
    }

    /**
     * @return string
     */
    public function getSeoH1()
    {
        if (isset($this->directLink['lang']) && $this->directLink['lang']['h1']) {
            $this->pageH1 = str_replace(
                ['#городе#', '#nella citta#', '#телефон#'],
                [Yii::$app->city->getCityTitleWhere(), Yii::$app->city->getCityTitleWhere(), Yii::$app->partner->getPartnerPhone()],
                $this->directLink['lang']['h1']
            );
        }

        return $this->pageH1;
    }

    /**
     * @return string
     */
    public function getSeoContent()
    {
        $content = false;

        if (isset($this->directLink['lang']) && $this->directLink['lang']['content']) {
            $content = str_replace(
                ['#городе#', '#nella citta#', '#телефон#'],
                [Yii::$app->city->getCityTitleWhere(), Yii::$app->city->getCityTitleWhere(), Yii::$app->partner->getPartnerPhone()],
                $this->directLink['lang']['content']
            );
        }

        return $content;
    }
}
