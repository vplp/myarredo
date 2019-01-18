<?php

namespace console\controllers;

use Yii;
use yii\helpers\Console;
use yii\console\Controller;

use frontend\modules\location\models\City;

/**
 * Class SitemapSaleController
 *
 * @property int $countUrlInSitemap
 *
 * @package console\controllers
 */
class SitemapSaleController extends Controller
{
    public $filePath = '@root/web/sitemap/sale';

    /**
     * Количество URL в Sitemap (не более 50 000)
     * @var int
     */
    public $countUrlInSitemap = 25000;

    /** @var array */
    public $modelName;

    /** @var array */
    private $urls = [];

    /**
     * Create
     */
    public function actionCreate()
    {
        $this->stdout("SitemapSale: start create. \n", Console::FG_GREEN);

        ini_set("memory_limit", "-1");
        set_time_limit(0);

        if (!is_dir(Yii::getAlias($this->filePath))) {
            mkdir(Yii::getAlias($this->filePath), 0777, true);
        }

        // delete files
        array_map('unlink', glob(Yii::getAlias($this->filePath) . '/*.xml'));

        // list of cities
        $cities = City::findBase()->all();


        if (is_array($this->modelName)) {
            $model = new $this->modelName['class']();
            if (isset($this->modelName['behaviors'])) {
                $model->attachBehaviors($this->modelName['behaviors']);
            }
        } else {
            $model = new $this->modelName();
        }

//        $count = count($urls);
//        $count_files = ceil($count / $this->countUrlInSitemap);

        /** @var $city \frontend\modules\location\models\City */

        foreach ($cities as $city) {
            // urls
            $urls = [];

            $query = $model::findBase()->andWhere(['city_id' => $city['id']]);

            foreach ($query->batch(1000) as $models) {
                foreach ($models as $model) {
                    $urls[] = call_user_func($this->modelName['dataClosure'], $model);
                }
            }

            // create the sitemap sale file

            $filePath = Yii::getAlias($this->filePath . '/sitemap_sale_' . $city['alias'] . '.xml');
            $handle = fopen($filePath, "w");

            fwrite(
                $handle,
                '<?xml version="1.0" encoding="UTF-8"?>' .
                PHP_EOL .
                '<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'
            );

            for ($i = 0; $i < count($urls); $i++) {
                $url = $urls[$i];

                $str = PHP_EOL . "\t<url>" . PHP_EOL .
                    "\t\t<loc>" . $city->getSubDomainUrl() . $url['loc'] . "</loc>" . PHP_EOL .
                    "\t\t<lastmod>" . $url['lastmod'] . "</lastmod>" . PHP_EOL .
                    "\t\t<changefreq>" . $url['changefreq'] . "</changefreq>" . PHP_EOL .
                    "\t\t<priority>" . $url['priority'] . "</priority>" . PHP_EOL .
                    "\t</url>";

                fwrite($handle, $str);
            }

            fwrite($handle, PHP_EOL . '</sitemapindex>');
            fclose($handle);
            chmod($filePath, 0777);
        }

        $this->stdout("SitemapSale: end create. \n", Console::FG_GREEN);
    }
}
