<?php

namespace thread\modules\seo\modules\sitemap\console;

use Yii;
//
use thread\modules\seo\modules\{
    sitemap\models\Element,
    modellink\models\Modellink,
    pathcache\models\Pathcache
};

/**
 * Class FillController
 *
 * @package thread\modules\seo\modules\sitemap\console
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class FillController extends \yii\console\Controller
{
    public $defaultAction = 'index';

    public $hostInfo = 'base-url';
    public $rules = '@frontend/config/part/url-rules.php';

    /**
     * @param string $actionID
     * @return array
     */
    public function options($actionID)
    {
        return [
            'hostInfo',
            'rules'
        ];
    }

    /**
     * @return array
     */
    public function optionAliases()
    {
        return [
            'host' => 'hostInfo',
            'r' => 'rules'
        ];
    }

    /**
     * @param \yii\base\Action $action
     * @return bool
     */
    public function beforeAction($action)
    {
        $this->setParams();
        $urlManager = Yii::$app->urlManager;
        $r = Yii::getAlias($this->rules);
        if (is_readable($r)) {
            $urlManager->addRules(require $r);
        }
        $urlManager->setHostInfo($this->hostInfo);

        return parent::beforeAction($action);
    }

    /**
     *
     */
    protected function setParams()
    {
        $seo = Yii::$app->getModule('seo');
        if (isset($seo->params['map']['hostInfo'])) {
            $this->hostInfo = $seo->params['map']['hostInfo'];
        };
        if (isset($seo->params['map']['rules'])) {
            $this->rules = $seo->params['map']['rules'];
        };
    }

    /**
     * @var array
     */
    protected $seoModelList = [

    ];

    /**
     *
     */
    public function actionIndex()
    {
        $this->stdout("Start Filling\n");
        $this->getClassFromCache();
        foreach ($this->seoModelList as $model) {
            if (method_exists(new $model['classname'], 'getLang')) {
                $this->clean($model['model_key'])->addElementsToSiteMapModelWithLang($model['classname'], $model['model_key']);
            } else {
                $this->clean($model['model_key'])->addElementsToSiteMapModelWithoutLang($model['classname'], $model['model_key']);
            }
        }

        $this->updateRel();

        $this->stdout("End Filling\n");
    }

    /**
     * @return $this
     */
    protected function updateRel()
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
    protected function getClassFromCache()
    {
        $this->seoModelList = Pathcache::getAllasArrayEnabled();
    }

    /**
     * @param string $model
     * @param string $model_key
     * @return $this
     */
    protected function addElementsToSiteMapModelWithLang(string $model, string $model_key)
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
    protected function addElementsToSiteMapModelWithoutLang(string $model, string $model_key)
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
    protected function clean($model_key)
    {
        set_time_limit(0);

        $connection = Element::getDb();
        $connection->createCommand()->delete(Element::tableName(), 'model_key = \'' . $model_key . '\'')->execute();

        return $this;
    }
}