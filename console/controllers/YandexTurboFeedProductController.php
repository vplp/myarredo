<?php

namespace console\controllers;

use frontend\modules\location\models\Currency;
use Yii;
use yii\helpers\Console;
use yii\console\Controller;
use frontend\modules\location\models\City;
use frontend\modules\catalog\models\{Category};
use console\models\{Product};

/**
 * Class YandexTurboFeedProductController
 *
 * @package console\controllers
 */
class YandexTurboFeedProductController extends Controller
{
    public $filePath = '@root/web/turbo-feed/product/';

    /**
     * Create
     */
    public function actionCreate()
    {
        $this->stdout("YandexTurboFeed: start create. \n", Console::FG_GREEN);

        ini_set("memory_limit", "-1");
        set_time_limit(0);

        if (!file_exists(Yii::getAlias($this->filePath))) {
            mkdir(Yii::getAlias($this->filePath), 0777, true);
        }

        // delete files
        array_map('unlink', glob(Yii::getAlias($this->filePath) . '/*.xml'));

        // list of cities
        $cities = City::findBase()
            ->joinWith(['country', 'country.lang'])
            ->andFilterWhere(['IN', 'country_id', [2]])
            ->all();

        $categories = Category::findBase()->all();

        $query = Product::findBase();

        $offers = [];
        foreach ($query->batch(100) as $models) {
            foreach ($models as $item) {
                $offers[] = $item;
            }
        }

        //$offers = Product::findBase()->all();

        /** @var $city City */
        foreach ($cities as $city) {
            $this->createFeed($city, $categories, $offers);
        }

        $this->stdout("YandexTurboFeed: end create. \n", Console::FG_GREEN);
    }

    /**
     * @param $city
     * @param $categories
     * @param $offers
     */
    protected function createFeed($city, $categories, $offers)
    {
        if ($offers) {
            $filePath = Yii::getAlias($this->filePath . '/turbo_feed_product_' . $city['alias'] . '.xml');

            $handle = fopen($filePath, "w");

            fwrite(
                $handle,
                "<?xml version=\"1.0\" encoding=\"UTF-8\"?>" . PHP_EOL .
                "<yml_catalog date=\"" . date('Y-m-d H:i') . "\">" . PHP_EOL .
                "<shop>" . PHP_EOL .
                "<name>MyArredoFamily</name>" . PHP_EOL .
                "<company>MyArredoFamily</company>" . PHP_EOL .
                "<url>" . City::getSubDomainUrl($city) . "</url>" . PHP_EOL
            );

            $currencies = Currency::findBase()->all();

            fwrite($handle, "<currencies>" . PHP_EOL);
            foreach ($currencies as $currency) {
                fwrite(
                    $handle,
                    "\t<currency id=\"" . ($currency['code2'] == 'RUB' ? 'RUR' : $currency['code2']) . "\" rate=\"" . $currency['course'] . "\"/>" . PHP_EOL
                );
            }
            fwrite($handle, "</currencies>" . PHP_EOL);

            fwrite(
                $handle,
                "<categories>" . PHP_EOL
            );
            foreach ($categories as $category) {
                fwrite(
                    $handle,
                    "\t<category id=\"" . $category['id'] . "\">" .
                    strip_tags($category['lang']['title']) .
                    "</category>" . PHP_EOL
                );
            }
            fwrite(
                $handle,
                "</categories>" . PHP_EOL .
                "<offers>" . PHP_EOL
            );

            foreach ($offers as $offer) {
                /** @var $offer Product */
                if (!empty($offer['category'])) {
                    $url = City::getSubDomainUrl($city) . '/sale-italy-product/' . $offer['alias'] . '/';

                    $str = "\t<offer id=\"" . $offer['id'] . "\">" . PHP_EOL .
                        "\t\t<name>" . htmlspecialchars($offer['lang']['title']) . "</name>" . PHP_EOL .
                        "\t\t<url>" . $url . "</url>" . PHP_EOL .
                        "\t\t<price>" . $offer['price_from'] . "</price>" . PHP_EOL .
                        "\t\t<currencyId>" . ($offer['currency'] == 'RUB' ? 'RUR' : $offer['currency']) . "</currencyId>" . PHP_EOL .
                        "\t\t<categoryId>" . ($offer['category'] ? $offer['category'][0]['id'] : 0) . "</categoryId>" . PHP_EOL .
                        "\t\t<picture>" . Product::getImageThumb($offer['image_link']) . "</picture>" . PHP_EOL;

                    if ($offer['lang']['description']) {
                        $str .= "\t\t<description><![CDATA[" . strip_tags($offer['lang']['description']) . "]]></description>" . PHP_EOL;
                    }

//                $array = [];
//                foreach ($offer['specificationValue'] as $item) {
//                    if ($item['specification']['parent_id'] == 2) {
//                        $array[] = $item['specification']['lang']['title'];
//                    }
//                }
//                if ($array) {
//                    $str .= "\t\t<param name=\"Материал\">" . implode(', ', $array) . "</param>" . PHP_EOL;
//                }
//
//                $array = [];
//                foreach ($offer['specificationValue'] as $item) {
//                    if ($item['specification']['parent_id'] == 9) {
//                        $array[] = $item['specification']['lang']['title'];
//                    }
//                }
//                if ($array) {
//                    $str .= "\t\t<param name=\"Стиль\">" . implode(', ', $array) . "</param>" . PHP_EOL;
//                }
//
//                foreach ($offer['specificationValue'] as $item) {
//                    if ($item['specification']['parent_id'] == 4) {
//                        $str .= "\t\t<param name=\"" . $item['specification']['lang']['title'] . " (см)\">" . $item['val'] . "</param>" . PHP_EOL;
//                    }
//                }
//
//                if (!empty($offer['colors'])) {
//                    $array = [];
//                    foreach ($offer['colors'] as $item) {
//                        $array[] = $item['lang']['title'];
//                    }
//                    $str .= "\t\t<param name=\"Цвет\">" . implode(', ', $array) . "</param>" . PHP_EOL;
//                }

                    $str .= "\t</offer>" . PHP_EOL;

                    fwrite($handle, $str);
                }
            }

            fwrite(
                $handle,
                "</offers>" . PHP_EOL .
                "</shop>" . PHP_EOL .
                "</yml_catalog>"
            );

            fclose($handle);
            chmod($filePath, 0777);
        }
    }
}
