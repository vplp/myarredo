<?php

namespace frontend\modules\seo\controllers;

use Yii;
use frontend\modules\seo\models\SitemapElement;
use frontend\modules\seo\models\SitemapXMLSimple;
use frontend\modules\seo\models\SitemapXMLElement;

/**
 * Class SitemapController
 *
 * @package app\modules\sitemap\controllers
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c) 2015, VipDesign
 */
class SitemapController extends \frontend\components\BaseController
{

    public $title = "Sitemap";
    public $defaultAction = 'index';
    
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => \yii\filters\VerbFilter::className(),
                'actions' => [
                    'mapcreate' => ['get'],
                    'filling' => ['get'],
                ],
            ],
        ];
    }

    /**
     * @param string $secretKey
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionMapcreate($secretKey)
    {
        if ($secretKey !== $this->module->secretKey) {
            throw new \yii\web\NotFoundHttpException;
        }

        $filepath = Yii::getAlias('@webroot') . '/sitemap.xml';
        if ($handle = fopen($filepath, 'w+')) {

            set_time_limit(0);

            fwrite($handle, SitemapXMLSimple::headTag());
            fwrite($handle, SitemapXMLSimple::beginTag());

            $elements = SitemapElement::find();

            $map = new SitemapXMLSimple;

            foreach ($elements->batch(500) as $item) {
                $r = [];
                foreach ($item as $i) {
                    $r[] = (new SitemapXMLElement([
                        'loc' => $i->url,
                        'lastmod' => $i->updated_at,
                            ]))->render();
                }
                fwrite($handle, implode('', $r));
            }

            fwrite($handle, SitemapXMLSimple::endTag());
        } else {
            echo 'error open file';
        }
    }

    /**
     * Filling base
     */
    public function actionFilling($secretKey)
    {
        if ($secretKey !== $this->module->secretKey) {
            throw new \yii\web\NotFoundHttpException;
        }

        set_time_limit(0);

        $objects = $this->module->objects;

        foreach ($objects as $module_id => $module) {
            foreach ($module as $model_id => $model) {
                $this->cleanFill($module_id, $model_id);
                $this->fill($module_id, $model_id, $model);
            }
        }

    }

    /**
     * Заповнення даними бази визначеного модуля та моделі
     *
     * @param string $module_id
     * @param string $model_id
     * @param array $model ['class' => class, 'method' => method]
     */
    public function fill($module_id, $model_id, $model)
    {
        set_time_limit(0);
        $sitemapElements = [];

        $items = call_user_func([$model['class'], $model['method']]);

        foreach ($items->batch(500) as $item) {
            $sitemapElements = [];
            foreach ($item as $i) {
                $sitemapElements[] = [
                    'module_id' => $module_id,
                    'model_id' => $model_id,
                    'key' => $i->id,
                    'url' => (isset($model['urlMethod'])) ? $model['urlMethod']($i) : $i->getUrl(true),
                    'created_at' => time(),
                    'updated_at' => time(),
                ];
            }
            $connection = SitemapElement::getDb();
            $connection->createCommand()->batchInsert(SitemapElement::tableName(), array_keys($sitemapElements[0]), $sitemapElements)->execute();
        }
    }

    /**
     * Очищення даних визначеного модуля та моделі
     * 
     * @param string $module_id
     * @param string $model_id
     */
    public function cleanFill($module_id, $model_id)
    {
        set_time_limit(0);

        $connection = SitemapElement::getDb();
        $connection->createCommand()->delete(SitemapElement::tableName(), 'module_id = \'' . $module_id . '\' AND model_id = \'' . $model_id . '\'')->execute();
    }

}
