<?php

namespace console\controllers;

use Yii;
use yii\helpers\Console;
use yii\console\Controller;
//
use frontend\modules\location\models\City;
use frontend\modules\catalog\models\{Category, Types};
use console\models\{
    Product, Factory, Sale, ItalianProduct
};

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
    public $models = [];

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
        $cities = City::findBase()
            ->joinWith(['country', 'country.lang'])
            ->andFilterWhere(['IN', 'country_id', [1, 2, 3]])
            ->all();

        /** @var $city City */
        foreach ($cities as $city) {
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

                if (in_array($model::className(), [Sale::className()])) {
                    $query->andWhere(['city_id' => $city['id']]);
                }

                if (in_array($model::className(), [Types::className(), Category::className()])) {
                    $query->innerJoinWith(["sale"], false)
                        ->andFilterWhere([
                            Sale::tableName() . '.published' => '1',
                            Sale::tableName() . '.deleted' => '0',
                        ]);

                    $query
                        ->innerJoinWith(["sale.city saleCity"], false)
                        ->andFilterWhere(['IN', 'saleCity.id', $city['id']]);
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

            // create the sitemap file
            if ($urls) {
                $filePath = Yii::getAlias($this->filePath . '/sitemap_sale_' . $city['alias'] . '.xml');
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
                        "\t\t<loc>" . City::getSubDomainUrl($city) . $url['loc'] . "</loc>" . PHP_EOL .
                        "\t\t<lastmod>" . $url['lastmod'] . "</lastmod>" . PHP_EOL .
                        "\t\t<changefreq>" . $url['changefreq'] . "</changefreq>" . PHP_EOL .
                        "\t\t<priority>" . $url['priority'] . "</priority>" . PHP_EOL .
                        "\t</url>";

                    fwrite($handle, $str);

                    if ($city['id'] == 4) {
                        $languages = ['en', 'it'];
                        foreach ($languages as $lang) {
                            $str = PHP_EOL . "\t<url>" . PHP_EOL .
                                "\t\t<loc>" . City::getSubDomainUrl($city) . "/" . $lang . $url['loc'] . "</loc>" . PHP_EOL .
                                "\t\t<lastmod>" . $url['lastmod'] . "</lastmod>" . PHP_EOL .
                                "\t\t<changefreq>" . $url['changefreq'] . "</changefreq>" . PHP_EOL .
                                "\t\t<priority>" . $url['priority'] . "</priority>" . PHP_EOL .
                                "\t</url>";

                            fwrite($handle, $str);
                        }
                    }
                }

                fwrite($handle, PHP_EOL . '</urlset>');
                fclose($handle);
                chmod($filePath, 0777);
            }
        }

        $this->stdout("SitemapSale: end create. \n", Console::FG_GREEN);
    }
}
