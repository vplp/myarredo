<?php

namespace console\controllers;

use Yii;
use yii\helpers\Console;
use yii\console\Controller;

/**
 * Class SitemapController
 *
 * @package console\controllers
 */
class SitemapController extends Controller
{
    public $filepath = '@root/web/sitemap';

    /** @var array */
    public $models = [];

    /** @var array */
    public $urls = [];

    /**
     * Create
     */
    public function actionCreate()
    {
        $this->stdout("Start Create\n");

        $filepath = Yii::getAlias($this->filepath . '/sitemap.xml');

        if ($handle = fopen($filepath, 'w+')) {

            set_time_limit(0);

            fwrite($handle, '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'. PHP_EOL);

//            $urls = $this->urls;
//
//            foreach ($this->models as $modelName) {
//
//                if (is_array($modelName)) {
//                    $model = new $modelName['class'];
//                    if (isset($modelName['behaviors'])) {
//                        $model->attachBehaviors($modelName['behaviors']);
//                    }
//                } else {
//                    $model = new $modelName;
//                }
//
//                $query = $model::find()->all();
//
//                foreach($query as $model) {
//                    $urls[] = call_user_func($modelName['dataClosure'], $model);
//                }
//            }
//
//            foreach ($urls as $url) {
//
//                fwrite($handle, implode('', $r));
//            }

            fwrite($handle, '</urlset>'. PHP_EOL);
        } else {
            $this->stdout("error open file\n");
        }

        $this->stdout("End Create\n");

        //$this->stdout("Generate sitemap file.\n", Console::FG_GREEN);
    }
}