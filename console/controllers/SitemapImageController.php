<?php

namespace console\controllers;

use Yii;
use yii\helpers\Console;
use yii\console\Controller;
use frontend\modules\location\models\City;

/**
 * Class SitemapImageController
 *
 * @property int $countUrlInSitemapImage
 *
 * @package console\controllers
 */
class SitemapImageController extends Controller
{
    public $filePath = '@root/web/sitemap-image';

    /**
     * Количество URL в SitemapImage (не более 50 000)
     * @var int
     */
    public $countUrlInSitemapImage = 20000;

    /** @var array */
    public $models = [];

    /** @var array */
    public $urls = [];

    /**
     * Create
     */
    public function actionCreate()
    {
        $this->stdout("SitemapImage: start create. \n", Console::FG_GREEN);

        ini_set("memory_limit", "-1");
        set_time_limit(0);

        // delete files
        array_map('unlink', glob(Yii::getAlias($this->filePath) . '/*.xml'));

        // list of cities
        $cities = City::findBase()->joinWith(['country', 'country.lang'])->all();

        // urls
        $urls = $this->urls;

        foreach ($this->models as $modelName) {
            if (is_array($modelName)) {
                $model = new $modelName['class']();
                if (isset($modelName['behaviors'])) {
                    $model->attachBehaviors($modelName['behaviors']);
                }
            } else {
                $model = new $modelName();
            }

            $query = $model::findBaseArray();

            foreach ($query->batch(100) as $models) {
                foreach ($models as $model) {
                    $urls[] = call_user_func($modelName['dataClosure'], $model);
                }
            }
        }

        $count = count($urls);
        $count_files = ceil($count / $this->countUrlInSitemapImage);

        foreach ($cities as $city) {

            /** @var $city City */

            // create multiple SitemapImage files

            for ($i = 0; $i < $count_files; $i++) {
                $filePath = Yii::getAlias($this->filePath . '/sitemap_image_' . $city['alias'] . '_' . $i . '.xml');

                $handle = fopen($filePath, "w");

                fwrite(
                    $handle,
                    '<?xml version="1.0" encoding="UTF-8"?>' .
                    PHP_EOL .
                    '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" ' .
                    'xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">' . PHP_EOL
                );

                for ($j = $i * $this->countUrlInSitemapImage; $j <= ($i + 1) * $this->countUrlInSitemapImage; $j++) {
                    if (isset($urls[$j])) {
                        $url = $urls[$j];

                        $str = "\t<url>" . PHP_EOL .
                            "\t\t<loc>" . City::getSubDomainUrl($city) . $url['loc'] . "</loc>" . PHP_EOL .
                            "\t\t<image:image>" . PHP_EOL .
                            "\t\t\t<image:loc>https://img.myarredo." . $city['country']['alias'] . $url['image_link'] . "</image:loc>" . PHP_EOL .
                            "\t\t\t<image:title>" . htmlspecialchars($url['title']) . "</image:title>" . PHP_EOL .
                            "\t\t</image:image>" . PHP_EOL .
                            "\t</url>" . PHP_EOL;

                        fwrite($handle, $str);
                    }
                }

                fwrite($handle, PHP_EOL . '</urlset>');
                fclose($handle);
                chmod($filePath, 0777);
            }


            // create the main sitemap file

            $filePath = Yii::getAlias($this->filePath . '/sitemap_image_' . $city['alias'] . '.xml');
            $handle = fopen($filePath, "w");

            fwrite(
                $handle,
                '<?xml version="1.0" encoding="UTF-8"?>' .
                PHP_EOL .
                '<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'
            );

            for ($i = 0; $i < $count_files; $i++) {
                $link = '/sitemap-image/sitemap_image_' . $city['alias'] . '_' . $i . '.xml';
                $str = PHP_EOL . "\t<sitemap>"
                    . PHP_EOL . "\t\t<loc>" . City::getSubDomainUrl($city) . $link . "</loc>"
                    . PHP_EOL . "\t\t<lastmod>" . date(DATE_W3C) . "</lastmod>"
                    . PHP_EOL . "\t</sitemap>";
                fwrite($handle, $str);
            }

            fwrite($handle, PHP_EOL . '</sitemapindex>');
            fclose($handle);
            chmod($filePath, 0777);
        }

        $this->stdout("SitemapImage: end create. \n", Console::FG_GREEN);
    }
}
