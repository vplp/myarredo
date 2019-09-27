<?php

namespace console\controllers;

use Yii;
use yii\helpers\Console;
use yii\console\Controller;
//
use frontend\modules\location\models\City;
use frontend\modules\catalog\models\{Category, Product, Types, Factory};

/**
 * Class SitemapController
 *
 * @property int $countUrlInSitemap
 *
 * @package console\controllers
 */
class SitemapController extends Controller
{
    public $filePath = '@root/web/sitemap';

    /**
     * Количество URL в Sitemap (не более 50 000)
     * @var int
     */
    public $countUrlInSitemap = 25000;

    /** @var array */
    public $models = [];

    /** @var array */
    public $urls = [];

    /**
     * Create
     */
    public function actionCreate()
    {
        $this->stdout("Sitemap: start create. \n", Console::FG_GREEN);

        ini_set("memory_limit", "-1");
        set_time_limit(0);

        // delete files
        array_map('unlink', glob(Yii::getAlias($this->filePath) . '/*.xml'));

        // list of cities
        $cities = City::findBase()
            ->joinWith(['country', 'country.lang'])
            ->andFilterWhere(['IN', 'country_id', [1, 2, 3]])
            ->all();

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

            $query = $model::findBase();

            if (in_array($model::className(), [Types::className(), Category::className()])) {
                $query
                    ->innerJoinWith(["product"], false)
                    ->innerJoinWith(["product.factory"], false)
                    ->andFilterWhere([
                        Product::tableName() . '.published' => '1',
                        Product::tableName() . '.deleted' => '0',
                        Product::tableName() . '.removed' => '0',
                        Factory::tableName() . '.published' => '1',
                        Factory::tableName() . '.deleted' => '0',
                    ])
                    ->groupBy($model::tableName() . '.id');
            }

            $query->select([
                $model::tableName() . '.id',
                $model::tableName() . '.alias',
                $model::tableName() . '.updated_at',
            ]);

            foreach ($query->batch(1000) as $models) {
                foreach ($models as $model) {
                    $urls[] = call_user_func($modelName['dataClosure'], $model);
                }
            }
        }

        foreach ($cities as $city) {
            $urlsNew = $urls;
            // for msk
            if ($city['id'] == 4) {
                $languages = ['en', 'it'];
                foreach ($languages as $lang) {
                    foreach ($urls as $url) {
                        $urlsNew[] = array_merge($url, ['loc' => "/" . $lang . $url['loc']]);
                    }
                }
            }

            $count = count($urlsNew);
            $count_files = ceil($count / $this->countUrlInSitemap);

            /** @var $city City */
            // create multiple sitemap files
            for ($i = 0; $i < $count_files; $i++) {
                $filePath = Yii::getAlias($this->filePath . '/sitemap_' . $city['alias'] . '_' . $i . '.xml');

                $handle = fopen($filePath, "w");

                fwrite(
                    $handle,
                    '<?xml version="1.0" encoding="UTF-8"?>' .
                    PHP_EOL .
                    '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . PHP_EOL
                );

                if ($i == 0) {
                    // add domain site
                    $str = "\t<url>" . PHP_EOL .
                        "\t\t<loc>" . City::getSubDomainUrl($city) . "</loc>" . PHP_EOL .
                        "\t\t<lastmod>" . date(DATE_W3C) . "</lastmod>" . PHP_EOL .
                        "\t\t<changefreq>always</changefreq>" . PHP_EOL .
                        "\t\t<priority>1</priority>" . PHP_EOL .
                        "\t</url>" . PHP_EOL;

                    fwrite($handle, $str);
                }

                for ($j = $i * $this->countUrlInSitemap; $j < ($i + 1) * $this->countUrlInSitemap; $j++) {
                    if (isset($urlsNew[$j])) {
                        $url = $urlsNew[$j];

                        $str = "\t<url>" . PHP_EOL .
                            "\t\t<loc>" . City::getSubDomainUrl($city) . $url['loc'] . "</loc>" . PHP_EOL .
                            "\t\t<lastmod>" . $url['lastmod'] . "</lastmod>" . PHP_EOL .
                            "\t\t<changefreq>" . $url['changefreq'] . "</changefreq>" . PHP_EOL .
                            "\t\t<priority>" . $url['priority'] . "</priority>" . PHP_EOL .
                            "\t</url>" . PHP_EOL;

                        fwrite($handle, $str);
                    }
                }

                fwrite($handle, PHP_EOL . '</urlset>');
                fclose($handle);
                chmod($filePath, 0777);
            }

            // create the main sitemap file

            $filePath = Yii::getAlias($this->filePath . '/sitemap_' . $city['alias'] . '.xml');
            $handle = fopen($filePath, "w");

            fwrite(
                $handle,
                '<?xml version="1.0" encoding="UTF-8"?>' .
                PHP_EOL .
                '<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'
            );

            for ($i = 0; $i < $count_files; $i++) {
                $link = '/sitemap/sitemap_' . $city['alias'] . '_' . $i . '.xml';
                $str = PHP_EOL . "\t<sitemap>"
                    . PHP_EOL . "\t\t<loc>" . City::getSubDomainUrl($city) . $link . "</loc>"
                    . PHP_EOL . "\t\t<lastmod>" . date(DATE_W3C) . "</lastmod>"
                    . PHP_EOL . "\t</sitemap>";
                fwrite($handle, $str);
            }

            // Add sale file
            $link = '/sitemap/sale/sitemap_sale_' . $city['alias'] . '.xml';
            $str = PHP_EOL . "\t<sitemap>"
                . PHP_EOL . "\t\t<loc>" . City::getSubDomainUrl($city) . $link . "</loc>"
                . PHP_EOL . "\t\t<lastmod>" . date(DATE_W3C) . "</lastmod>"
                . PHP_EOL . "\t</sitemap>";
            fwrite($handle, $str);

            // Add italian product file
            $link = '/sitemap/italian_product/sitemap_italian_product_' . $city['alias'] . '.xml';
            $str = PHP_EOL . "\t<sitemap>"
                . PHP_EOL . "\t\t<loc>" . City::getSubDomainUrl($city) . $link . "</loc>"
                . PHP_EOL . "\t\t<lastmod>" . date(DATE_W3C) . "</lastmod>"
                . PHP_EOL . "\t</sitemap>";
            fwrite($handle, $str);

            fwrite($handle, PHP_EOL . '</sitemapindex>');
            fclose($handle);
            chmod($filePath, 0777);

            $this->stdout("Create sitemap_" . $city['alias'] . " \n", Console::FG_GREEN);
        }

        $this->stdout("Sitemap: end create. \n", Console::FG_GREEN);
    }
}
