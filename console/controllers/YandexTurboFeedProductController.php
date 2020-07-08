<?php

namespace console\controllers;

use frontend\modules\location\models\Currency;
use Yii;
use yii\helpers\Console;
use yii\console\Controller;
use frontend\modules\location\models\City;
use frontend\modules\catalog\models\{Category};
use console\models\{Product, Factory};

/**
 * Class YandexTurboFeedProductController
 *
 * @package console\controllers
 */
class YandexTurboFeedProductController extends Controller
{
    public $filePath = '@root/web/turbo-feed/product/';

    public $countOffersInFeed = 20000;

    public function actionParser()
    {
        /* connect to yandex */
        $hostname = '{imap.yandex.ru:993/imap/ssl}';
        $username = 'msk@myarredo.ru';
        $password = 'Msk_1234';

        /* try to connect */
        $inbox = imap_open($hostname . 'INBOX', $username, $password) or die('Cannot connect to Yandex: ' . imap_last_error());

//        $list = imap_list($inbox, $hostname, '*');
//        foreach ($list as $value) {
//            //var_dump($value);
//            var_dump(mb_convert_encoding($value, 'UTF-8', 'UTF7-IMAP'));
//        }


        $some = imap_search($inbox, 'SUBJECT "Jumbo group"', SE_UID);
        var_dump(mb_convert_encoding($some, 'UTF-8', 'UTF7-IMAP'));

//        $MC = imap_check($inbox);
//
//        // Получим обзор всех писем в INBOX
//        $result = imap_fetch_overview($inbox, "1:{$MC->Nmsgs}", 0);
//        foreach ($result as $overview) {
//            echo "#{$overview->msgno} ({$overview->date}) - From: {$overview->from} {$overview->subject}\n";
//        }
        imap_close($inbox);
    }

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

        $currencies = Currency::findBase()->all();

        $categories = Category::findBase()->all();

        $query = Product::findBase();

        $offers = [];
        foreach ($query->batch(100) as $models) {
            foreach ($models as $item) {
                $offers[] = $item;
            }
        }

        /** @var $city City */
        foreach ($cities as $city) {
            if ($city['id'] == 4) {
                $this->createFeed($city, $currencies, $categories, $offers);
            }
        }

        $this->stdout("YandexTurboFeed: end create. \n", Console::FG_GREEN);
    }

    /**
     * @param $city
     * @param $currencies
     * @param $categories
     * @param $offers
     */
    protected function createFeed($city, $currencies, $categories, $offers)
    {
        if ($offers) {
            $count = count($offers);
            $countFiles = ceil($count / $this->countOffersInFeed);

            for ($i = 0; $i < $countFiles; $i++) {
                $filePath = Yii::getAlias($this->filePath . '/turbo_feed_product_' . $city['alias'] . '_' . $i . '.xml');

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

                for ($j = $i * $this->countOffersInFeed; $j <= ($i + 1) * $this->countOffersInFeed; $j++) {
                    /** @var $offer Product */
                    if (isset($offers[$j]) && !empty($offers[$j]['category']) && Product::isImage($offers[$j]['image_link'])) {
                        $offer = $offers[$j];
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
                        } else {
                            $str .= "\t\t<description><![CDATA[" . htmlspecialchars($offer->getTitle()) . "]]></description>" . PHP_EOL;
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
}
