<?php

namespace frontend\modules\seo\modules\sitemap\controllers;

use Yii;
//
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
//
use thread\modules\seo\modules\sitemap\models\{
    XMLElement, XMLSimple
};
//
use frontend\modules\seo\modules\sitemap\models\Element;

/**
 * Class FillController
 *
 * @package frontend\modules\seo\modules\pathcache\controllers
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class CreateController extends \frontend\components\BaseController
{
    public $title = "Map";
    public $defaultAction = 'index';

    /**
     * @var array
     */
    protected $seoModelList = [

    ];

    /**
     * @inheritdoc
     */
    public function behaviors()
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

    /**
     * @param $secretKey
     * @throws NotFoundHttpException
     */
    public function actionIndex($secretKey)
    {
        if ($secretKey !== $this->module->secretKey) {
            throw new NotFoundHttpException;
        }

        echo "Start Create<br>";

        $filepath = Yii::getAlias('@webroot') . '/sitemap.xml';
        if ($handle = fopen($filepath, 'w+')) {

            set_time_limit(0);

            fwrite($handle, XMLSimple::headTag());
            fwrite($handle, XMLSimple::beginTag());

            $elements = Element::findAddToSitemap();

            $map = new XMLSimple();

            foreach ($elements->batch(500) as $item) {
                $r = [];
                foreach ($item as $i) {
                    $r[] = (new XMLElement([
                        'loc' => $i->url,
                        'lastmod' => $i->updated_at,
                    ]))->render();
                }
                fwrite($handle, implode('', $r));
            }

            fwrite($handle, XMLSimple::endTag());
        } else {
            echo 'error open file';
        }
        echo "End Create<br>";
    }
}