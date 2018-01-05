<?php

namespace console\controllers;

use Yii;
use yii\helpers\Console;
use yii\console\Controller;

use frontend\modules\location\models\City;

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
        $this->stdout("Generate sitemap start Create. \n", Console::FG_GREEN);

        // delete files
        array_map('unlink', glob(Yii::getAlias($this->filepath) . '/*.xml'));

        // list of cities
        $cities = City::findBase()->all();

        // urls
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

            $query = $model::findBase()->all();

            foreach($query as $model) {
                $urls[] = call_user_func($modelName['dataClosure'], $model);
            }
        }

        foreach ($cities as $city) {

            /**
             * @var $city \frontend\modules\location\models\City
             */

            // create file
            $filepath = Yii::getAlias($this->filepath . '/sitemap_'.$city['alias'].'.xml');

            if ($handle = fopen($filepath, 'w+')) {

                set_time_limit(0);

                fwrite($handle, '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL . '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . PHP_EOL);

                // add domain site
                $str = "\t<url>" . PHP_EOL .
                    "\t\t<loc>" . $city->getSubDomainUrl() . "</loc>" . PHP_EOL .
                    "\t\t<lastmod>" . date(DATE_W3C) . "</lastmod>" . PHP_EOL .
                    "\t\t<changefreq>always</changefreq>" . PHP_EOL .
                    "\t\t<priority>1</priority>" . PHP_EOL .
                    "\t</url>" . PHP_EOL;

                fwrite($handle, $str);

                foreach ($urls as $url) {
                    $str = "\t<url>" . PHP_EOL .
                        "\t\t<loc>" . $city->getSubDomainUrl() . $url['loc'] . "</loc>" . PHP_EOL .
                        "\t\t<lastmod>" . $url['lastmod'] . "</lastmod>" . PHP_EOL .
                        "\t\t<changefreq>" . $url['changefreq'] . "</changefreq>" . PHP_EOL .
                        "\t\t<priority>" . $url['priority'] . "</priority>" . PHP_EOL .
                        "\t</url>" . PHP_EOL;

                    fwrite($handle, $str);
                }

                fwrite($handle, '</urlset>');
            } else {
                $this->stdout("error open file. \n", Console::FG_GREEN);
            }
        }

        $this->stdout("Generate sitemap end Create. \n", Console::FG_GREEN);
    }
}