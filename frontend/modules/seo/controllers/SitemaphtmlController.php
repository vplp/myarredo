<?php

namespace frontend\modules\seo\controllers;

use yii\helpers\Url;
use yii\filters\VerbFilter;
//
use frontend\modules\page\models\Page;
use frontend\modules\catalog\models\Group;
use frontend\modules\catalog\modules\manufacturer\models\Trademark;

/**
 * Class SitemaphtmlController
 *
 * @package frontend\modules\seo\controllers
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class SitemaphtmlController extends \frontend\components\BaseController
{

    public $title = "Sitemaphtml";
    public $defaultAction = 'index';

    public $breadcrumbs = [
        [
            'label' => 'Pages'
        ]
    ];

    /**
     * @inheritdoc
     */
    public
    function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'index' => ['get'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $this->layout = "@app/layouts/page_no_sidebar";

        //
        $this->breadcrumbs[] = [
            'label' => 'Sitemap',
            'url' => Url::toRoute(['index'])
        ];
        //

        return $this->render('index', [
            'pages' => Page::getAllWithLabel(),
            'catalog_groups' => Group::getAllWithLabel(),
            'trademarks' => Trademark::getAllWithLabel()
        ]);
    }
}
