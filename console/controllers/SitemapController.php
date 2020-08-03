<?php

namespace console\controllers;

use Yii;
use yii\helpers\Console;
use yii\console\Controller;
use frontend\modules\location\models\City;
use frontend\modules\catalog\models\{Category, Product, Types, Factory};
use frontend\modules\seo\modules\directlink\models\Directlink;
use console\models\{
    Sale
};

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
    public $countUrlInSitemap = 20000;

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
        $urls = self::getUrls();

        foreach ($cities as $city) {
            $this->createSitemapFile($urls, City::getSubDomainUrl($city), $city);
        }

        $this->createSitemapFile($urls, 'https://' . 'www.myarredo.com', false);

        $this->stdout("Sitemap: end create. \n", Console::FG_GREEN);
    }

    /**
     * @param $urls
     * @param $baseUrl
     * @param $city
     */
    private function createSitemapFile(array $urls, string $baseUrl, $city = false)
    {
        if ($city == false) {
            $urls = [];
            $urlsIt = self::getUrls('it-IT', 'com');
            foreach ($urlsIt as $url) {
                $urls[] = array_merge($url, ['loc' => "/it" . $url['loc']]);
            }

            $urlsEn = self::getUrls('en-EN', 'com');
            foreach ($urlsEn as $url) {
                $urls[] = array_merge($url, ['loc' => "/en" . $url['loc']]);
            }
        }

        if ($city['country_id'] == 1) {
            foreach ($urls as $url) {
                $urls[] = array_merge($url, ['loc' => "/ua" . $url['loc']]);
            }
        }

        $count = count($urls);
        $count_files = ceil($count / $this->countUrlInSitemap);
        $this->stdout("count = " . $count . " \n", Console::FG_GREEN);
        $this->stdout("count = " . $count_files . " \n", Console::FG_GREEN);
        $templateName = ($city) ? '_' . $city['alias'] : '';

        /** @var $city City */
        // create multiple sitemap files
        for ($i = 0; $i < $count_files; $i++) {
            $filePath = Yii::getAlias($this->filePath . '/sitemap' . $templateName . '_' . $i . '.xml');

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
                    "\t\t<loc>" . $baseUrl . "</loc>" . PHP_EOL .
                    "\t\t<lastmod>" . date(DATE_W3C) . "</lastmod>" . PHP_EOL .
                    "\t\t<changefreq>always</changefreq>" . PHP_EOL .
                    "\t\t<priority>1</priority>" . PHP_EOL .
                    "\t</url>" . PHP_EOL;

                fwrite($handle, $str);
            }

            for ($j = $i * $this->countUrlInSitemap; $j <= ($i + 1) * $this->countUrlInSitemap; $j++) {
                if (isset($urls[$j])) {
                    $url = $urls[$j];

                    $str = "\t<url>" . PHP_EOL .
                        "\t\t<loc>" . $baseUrl . $url['loc'] . "</loc>" . PHP_EOL .
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

        $filePath = Yii::getAlias($this->filePath . '/sitemap' . $templateName . '.xml');
        $handle = fopen($filePath, "w");

        fwrite(
            $handle,
            '<?xml version="1.0" encoding="UTF-8"?>' .
            PHP_EOL .
            '<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'
        );

        for ($i = 0; $i < $count_files; $i++) {
            $link = '/sitemap/sitemap' . $templateName . '_' . $i . '.xml';
            $str = PHP_EOL . "\t<sitemap>"
                . PHP_EOL . "\t\t<loc>" . $baseUrl . $link . "</loc>"
                . PHP_EOL . "\t\t<lastmod>" . date(DATE_W3C) . "</lastmod>"
                . PHP_EOL . "\t</sitemap>";
            fwrite($handle, $str);
        }

        if ($city) {
            $query = Sale::findBaseArray();
            $query->andWhere(['city_id' => $city['id']]);
            $query->select([
                Sale::tableName() . '.id',
                Sale::tableName() . '.alias',
                Sale::tableName() . '.updated_at',
            ]);

            if ($query->count()) {
                // Add sale file
                $link = '/sitemap/sale/sitemap_sale' . $templateName . '.xml';
                $str = PHP_EOL . "\t<sitemap>"
                    . PHP_EOL . "\t\t<loc>" . $baseUrl . $link . "</loc>"
                    . PHP_EOL . "\t\t<lastmod>" . date(DATE_W3C) . "</lastmod>"
                    . PHP_EOL . "\t</sitemap>";
                fwrite($handle, $str);
            }
        }

        // Add italian product file
        $link = '/sitemap/italian_product/sitemap_italian_product' . $templateName . '.xml';
        $str = PHP_EOL . "\t<sitemap>"
            . PHP_EOL . "\t\t<loc>" . $baseUrl . $link . "</loc>"
            . PHP_EOL . "\t\t<lastmod>" . date(DATE_W3C) . "</lastmod>"
            . PHP_EOL . "\t</sitemap>";
        fwrite($handle, $str);

        fwrite($handle, PHP_EOL . '</sitemapindex>');
        fclose($handle);
        chmod($filePath, 0777);

        $this->stdout("Create sitemap" . $templateName . " \n", Console::FG_GREEN);
    }

    /**
     * @param string $language
     * @param string $domain
     * @return array
     */
    private function getUrls($language = 'ru-RU', $domain = 'ru')
    {
        $_urls = $this->urls;

        $currentLanguage = Yii::$app->language;
        Yii::$app->language = $language;

        $languageModels = ($language == 'ru-RU') ? $this->models['ru'] : $this->models['en'];

        foreach ($languageModels as $modelName) {
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

                $query->select([
                    $model::tableName() . '.id',
                    $model::tableName() . '.alias',
                    $model::tableName() . '.alias_en',
                    $model::tableName() . '.updated_at',
                ]);
            } elseif ($model::className() == Directlink::className()) {
                $query->select([
                    $model::tableName() . '.id',
                    $model::tableName() . '.url',
                    $model::tableName() . '.updated_at',
                ]);
            } elseif ($model::className() == Factory::className() && $domain) {
                $query
                    ->select([
                        $model::tableName() . '.id',
                        $model::tableName() . '.url',
                        $model::tableName() . '.updated_at',
                    ])
                    ->andFilterWhere([
                        self::tableName() . '.show_for_' . $domain => '1',
                    ]);
            } else {
                $query->select([
                    $model::tableName() . '.id',
                    $model::tableName() . '.alias',
                    $model::tableName() . '.updated_at',
                ]);
            }

            foreach ($query->batch(100) as $models) {
                foreach ($models as $item) {
                    $_urls[] = call_user_func($modelName['dataClosure'], $item);
                }
            }
        }

        Yii::$app->language = $currentLanguage;

        return $_urls;
    }
}
