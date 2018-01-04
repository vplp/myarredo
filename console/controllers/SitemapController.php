<?php

namespace console\controllers;

use yii\helpers\Console;
use yii\console\Controller;

/**
 * Class SitemapController
 *
 * @package console\controllers
 */
class SitemapController extends Controller
{
    /** @var array */
    public $models = [];

    /** @var array */
    public $urls = [];

    /**
     * Create
     */
    public function actionCreate()
    {
        $urls = $this->urls;

        foreach ($this->models as $modelName) {

            if (is_array($modelName)) {
                $model = new $modelName['class'];
                if (isset($modelName['behaviors'])) {
                    $model->attachBehaviors($modelName['behaviors']);
                }
            } else {
                $model = new $modelName;
            }

            $query = $model::find()->all();

            ///* !!! */ echo  '<pre style="color:red;">'; print_r($query); echo '</pre>'; /* !!! */

            foreach($query as $model) {
                $urls[] = call_user_func($modelName['dataClosure'], $model);

                //$urls = array_merge($urls, $urlData);
            }


        }

        /* !!! */ echo  '<pre style="color:red;">'; print_r($urls); echo '</pre>'; /* !!! */
        //$this->stdout("Generate sitemap file.\n", Console::FG_GREEN);
    }
}