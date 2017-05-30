<?php

namespace frontend\modules\seo\modules\sitemap\controllers;

use Yii;
use yii\web\NotFoundHttpException;
//
use yii\filters\VerbFilter;
//
use frontend\modules\seo\modules\{
    sitemap\models\Element,
    pathcache\models\Pathcache,
    modellink\models\Modellink
};

/**
 * Class FillController
 *
 * @package frontend\modules\seo\modules\pathcache\controllers
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class FillController extends \frontend\components\BaseController
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

        echo "Start Filling<br>";
        $this->getClassFromCache();
        foreach ($this->seoModelList as $model) {
            if (method_exists(new $model['classname'], 'getLang')) {
                $this->clean($model['model_key'])->addElementsToSiteMapModelWithLang($model['classname'], $model['model_key']);
            } else {
                $this->clean($model['model_key'])->addElementsToSiteMapModelWithoutLang($model['classname'], $model['model_key']);
            }
        }

        $this->updateRel();

        echo "End Filling<br>";
    }

    /**
     *
     */
//    public function actionRel()
//    {
//        echo "Start Update Rel<br>";
//        $this->updateRel();
//        echo "End Update Rel<br>";
//    }

    /**
     * @return $this
     */
    public function updateRel()
    {
        $connection = Element::getDb();

        $eTable = Element::tableName();
        $lTable = Modellink::tableName();
//UPDATE fv_seo_sitemap_element LEFT JOIN fv_seo_model_link ON fv_seo_model_link.model_key=fv_seo_sitemap_element.model_key AND fv_seo_model_link.model_id=fv_seo_sitemap_element.model_id AND fv_seo_model_link.lang=fv_seo_sitemap_element.lang SET fv_seo_sitemap_element.add_to_sitemap = IF(fv_seo_model_link.published = '1', fv_seo_model_link.add_to_sitemap, '1') , fv_seo_sitemap_element.dissallow_in_robotstxt = IF(fv_seo_model_link.published = '1', fv_seo_model_link.dissallow_in_robotstxt, '0')
        $q = "UPDATE " . $eTable . " LEFT JOIN " . $lTable . " ON " . $lTable . ".model_key=" . $eTable . ".model_key AND " . $lTable . ".model_id=" . $eTable . ".model_id AND " . $lTable . ".lang=" . $eTable . ".lang SET " . $eTable . ".add_to_sitemap = IF(" . $lTable . ".published = '1', " . $lTable . ".add_to_sitemap, '1') , " . $eTable . ".dissallow_in_robotstxt = IF(" . $lTable . ".published = '1', " . $lTable . ".dissallow_in_robotstxt, '0')";
        $connection->createCommand($q)->execute();
        return $this;
    }

    /**
     *
     */
    public function getClassFromCache()
    {
        $this->seoModelList = Pathcache::getAll();
    }

    /**
     * @param string $model
     * @param string $model_key
     * @return $this
     */
    public function addElementsToSiteMapModelWithLang(string $model, string $model_key)
    {
        set_time_limit(0);

        $saveAppLanguage = Yii::$app->language;
        //
        $langs = Yii::$app->languages->getAll();
        //
        foreach ($langs as $lang) {
            $lng = $lang['local'];
            Yii::$app->language = $lang['local'];
            //
            $items = call_user_func([$model, 'findSeo']);

            foreach ($items->batch(200) as $item) {
                $sitemapElements = [];
                foreach ($item as $i) {
                    $sitemapElements[] = [
                        'model_key' => $model_key,
                        'model_id' => $i->id,
                        'lang' => $lng,
                        'add_to_sitemap' => Element::STATUS_KEY_ON,
                        'dissallow_in_robotstxt' => Element::STATUS_KEY_OFF,
                        'url' => $i->getUrl(true),
                    ];
                }
                $connection = Element::getDb();
                $connection->createCommand()->batchInsert(Element::tableName(), array_keys($sitemapElements[0]), $sitemapElements)->execute();
            }
        }
        //
        Yii::$app->language = $saveAppLanguage;

        return $this;
    }

    /**
     * @param string $model
     * @param string $model_key
     * @return $this
     */
    public function addElementsToSiteMapModelWithoutLang(string $model, string $model_key)
    {
        set_time_limit(0);
        $items = call_user_func([$model, 'findSeo']);

        foreach ($items->batch(200) as $item) {
            $sitemapElements = [];
            foreach ($item as $i) {
                $sitemapElements[] = [
                    'model_key' => $model_key,
                    'model_id' => $i->id,
                    'lang' => '',
                    'add_to_sitemap' => Element::STATUS_KEY_ON,
                    'dissallow_in_robotstxt' => Element::STATUS_KEY_OFF,
                    'url' => $i->getUrl(true),
                ];
            }
            $connection = Element::getDb();
            $connection->createCommand()->batchInsert(Element::tableName(), array_keys($sitemapElements[0]), $sitemapElements)->execute();
        }

        return $this;
    }

    /**
     * @param $model_key
     * @return $this
     */
    public function clean($model_key)
    {
        set_time_limit(0);

        $connection = Element::getDb();
        $connection->createCommand()->delete(Element::tableName(), 'model_key = \'' . $model_key . '\'')->execute();

        return $this;
    }
}