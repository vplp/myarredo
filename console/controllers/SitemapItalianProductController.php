<?php

namespace console\controllers;

use Yii;
use yii\helpers\Console;
use yii\console\Controller;
use frontend\modules\location\models\City;
use frontend\modules\catalog\models\{Category, ItalianProduct, Types};

/**
 * Class SitemapItalianProductController
 *
 * @property int $countUrlInSitemap
 *
 * @package console\controllers
 */
class SitemapItalianProductController extends Controller
{
    public $filePath = '@root/web/sitemap/italian_product';

    /**
     * Количество URL в Sitemap (не более 50 000)
     * @var int
     */
    public $countUrlInSitemap = 20000;

    /** @var array */
    public $models = [];

    /** @var array */
    private $urls = [];

    /**
     * Create
     */
    public function actionCreate()
    {
        $this->stdout("SitemapItalianProduct: start create. \n", Console::FG_GREEN);

        ini_set("memory_limit", "-1");
        set_time_limit(0);

        if (!is_dir(Yii::getAlias($this->filePath))) {
            mkdir(Yii::getAlias($this->filePath), 0777, true);
        }

        // delete files
        array_map('unlink', glob(Yii::getAlias($this->filePath) . '/*.xml'));

        // list of cities
        $cities = City::findBase()
            ->joinWith(['country', 'country.lang'])
            ->andFilterWhere(['IN', 'country_id', [1, 2, 3, 4, 5, 85, 114, 109]])
            ->all();

        $urlsRu = self::getUrls('ru-RU');
        foreach ($cities as $city) {
            if ($city['country_id'] == 4) {
                // italy
                $urls = [];
                $urlsIt = self::getUrls('it-IT');
                foreach ($urlsIt as $url) {
                    $urls[] = array_merge($url, ['loc' => "/it" . $url['loc']]);
                }

                $urlsEn = self::getUrls('en-EN');
                foreach ($urlsEn as $url) {
                    $urls[] = array_merge($url, ['loc' => "/en" . $url['loc']]);
                }

                $this->createSitemapFile($urls, 'https://' . 'www.myarredo.com', $city);
            } elseif ($city['country_id'] == 5) {
                // usa
                $this->createSitemapFile(self::getUrls('en-EN'), 'https://' . 'www.myarredofamily.com', $city);
            } elseif ($city['country_id'] == 85) {
                // germany
                $this->createSitemapFile(self::getUrls('de-DE'), 'https://' . 'www.myarredo.de', $city);
            } elseif ($city['country_id'] == 109) {
                // germany
                $this->createSitemapFile(self::getUrls('he-IL'), 'https://' . 'www.myarredo.co.il', $city);
            } elseif ($city['country_id'] == 1) {
                $urlsUa = self::getUrls('uk-UA');

                $urls = $urlsRu;
                foreach ($urlsUa as $url) {
                    $urls[] = array_merge($url, ['loc' => "/ua" . $url['loc']]);
                }
                $this->createSitemapFile($urls, City::getSubDomainUrl($city), $city);
            } elseif ($city['country_id'] == 114) {
                $this->createSitemapFile($urlsRu, 'https://' . 'www.myarredo.kz', $city);
            } else {
                $this->createSitemapFile($urlsRu, City::getSubDomainUrl($city), $city);
            }
        }

        $this->stdout("SitemapItalianProduct: end create. \n", Console::FG_GREEN);
    }

    private function getUrls($language = 'ru-RU')
    {
        $_urls = $this->urls;

        $currentLanguage = Yii::$app->language;
        Yii::$app->language = $language;

        $lang = substr(Yii::$app->language, 0, 2);
        $languageModels = $this->models[$lang];

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
                $query->innerJoinWith(["italianProduct"], false)
                    ->andFilterWhere([
                        ItalianProduct::tableName() . '.published' => '1',
                        ItalianProduct::tableName() . '.deleted' => '0',
                    ])
                    ->groupBy($model::tableName() . '.id');

                $query->select([
                    $model::tableName() . '.id',
                    $model::tableName() . '.alias',
                    $model::tableName() . '.alias_en',
                    $model::tableName() . '.alias_it',
                    $model::tableName() . '.alias_de',
                    $model::tableName() . '.alias_he',
                    $model::tableName() . '.updated_at',
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

    /**
     * @param array $urls
     * @param string $baseUrl
     * @param bool $city
     */
    private function createSitemapFile(array $urls, string $baseUrl, array $city)
    {
//        if ($city == false) {
//            $urls = [];
//            $urlsIt = self::getUrls('it-IT');
//            foreach ($urlsIt as $url) {
//                $urls[] = array_merge($url, ['loc' => "/it" . $url['loc']]);
//            }
//
//            $urlsEn = self::getUrls('en-EN');
//            foreach ($urlsEn as $url) {
//                $urls[] = array_merge($url, ['loc' => "/en" . $url['loc']]);
//            }
//
//            $templateName = '';
//        } else {
//            $templateName = '_' . $city['alias'];
//        }


        if ($urls) {
            $templateName = !empty($city) ? '_' . $city['alias'] : '';

            $filePath = Yii::getAlias($this->filePath . '/sitemap_italian_product' . $templateName . '.xml');
            $handle = fopen($filePath, "w");

            fwrite(
                $handle,
                '<?xml version="1.0" encoding="UTF-8"?>' .
                PHP_EOL .
                '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . PHP_EOL
            );

            for ($i = 0; $i < count($urls); $i++) {
                $url = $urls[$i];

                $str = PHP_EOL . "\t<url>" . PHP_EOL .
                    "\t\t<loc>" . $baseUrl . $url['loc'] . "</loc>" . PHP_EOL .
                    "\t\t<lastmod>" . $url['lastmod'] . "</lastmod>" . PHP_EOL .
                    "\t\t<changefreq>" . $url['changefreq'] . "</changefreq>" . PHP_EOL .
                    "\t\t<priority>" . $url['priority'] . "</priority>" . PHP_EOL .
                    "\t</url>";

                fwrite($handle, $str);
            }

            fwrite($handle, PHP_EOL . '</urlset>');
            fclose($handle);
            chmod($filePath, 0777);
        }
    }
}
