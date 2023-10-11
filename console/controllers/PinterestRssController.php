<?php

namespace console\controllers;

use frontend\modules\location\models\Currency;
use Yii;
use yii\helpers\Console;
use yii\console\Controller;
use frontend\modules\location\models\City;
use frontend\modules\catalog\models\{Category};
use console\models\{Sale};
use console\models\{Product, Factory};

/**
 * Class PinterestRssController
 *
 * @package console\controllers
 */
class PinterestRssController extends Controller
{
    public $filePath = '@root/web/rss/';

    /**
     * Create
     */
    public function actionCreate()
    {
        $this->stdout("PinterestRss: start create. \n", Console::FG_GREEN);

        ini_set("memory_limit", "-1");
        set_time_limit(0);

        if (!file_exists(Yii::getAlias($this->filePath))) {
            mkdir(Yii::getAlias($this->filePath), 0777, true);
        }

        // delete files
        array_map('unlink', glob(Yii::getAlias($this->filePath) . '/*.xml'));

        // list of categories
        $categories = Category::findBase()
            ->andWhere(['published' => '1'])
            ->all();

        foreach ($categories as $key => $category) {
            $offers = Product::findBaseArray()
                ->innerJoinWith([
                    'category',
                    'category.lang',
                    //'types',
                    //'types.lang',
                    'specificationValue',
                    'specificationValue.specification',
                    'specificationValue.specification.lang',
                    //'collection',
                    //'colors',
                    //'colors.lang',
                ])->andFilterWhere([
                    'IN',
                    Category::tableName() . '.alias',
                    $category['alias']
                ])->all();

            $this->createFeed($category, $offers);

            /*$offers = [];
            foreach ($query->batch(100) as $models) {
                foreach ($models as $item) {
                    $offers[] = $item;
                }
            }*/
        }

        $this->stdout("PinterestRss: end create. \n", Console::FG_GREEN);
    }

    /**
     * @param $city
     * @param $offers
     */
    protected function createFeed($category, $offers)
    {
        if ($offers) {
            $filePath = Yii::getAlias($this->filePath . '/rss_' . $category['alias'] . '.xml');

            $handle = fopen($filePath, "w");

            fwrite(
                $handle,
                "<?xml version=\"1.0\"?>" . PHP_EOL .
                "<rss version=\"2.0\">" . PHP_EOL .
                "\t<channel>" . PHP_EOL .
                "\t\t<title>MYARREDO — подбор итальянской мебели от производителя</title>" . PHP_EOL .
                "\t\t<link>https://www.myarredo.ru/</link>" . PHP_EOL .
                "\t\t<description>Портал MYARREDO — проверенные салоны продаж итальянской мебели в более, чем 70 городах России</description>" . PHP_EOL
            );

            foreach ($offers as $offer) {
                /** @var $offer Sale */
                $url = 'https://www.myarredo.ru/product/' . $offer['alias'] . '/';
                $description = "";
                // Фабрика
                if ($offer['factory'] != null) {
                    $description .= "Фабрика " . htmlspecialchars($offer['factory']['title']) . PHP_EOL;
                }
                // Стиль
                $array = [];
                foreach ($offer['specificationValue'] as $item) {
                    if ($item['specification']['parent_id'] == 9) {
                        $array[] = htmlspecialchars($item['specification']['lang']['title']);
                    }
                }
                if ($array) {
                    $description .= "Стиль " . implode(', ', $array) . PHP_EOL;
                }
                if ($offer['lang']['description']) {
                    $description .= strip_tags($offer['lang']['description']) . PHP_EOL;
                } else {
                    $description .= htmlspecialchars($offer['lang']['title']) . PHP_EOL;
                }
                $str = "\t\t<item>" . PHP_EOL .
                    "\t\t\t<title>" . htmlspecialchars($offer['lang']['title']) . "</title>" . PHP_EOL .
                    "\t\t\t<link>" . $url . "</link>" . PHP_EOL .
                    "\t\t\t<guid>" . $url . "</guid>" . PHP_EOL;
                    
                if (Product::isImage($offer['image_link'])) {
                    $str .= "\t\t\t<enclosure url=\"" . Product::getImage($offer['image_link']) . "\" type=\"image/jpeg\"/>" . PHP_EOL;
                }

                if (!empty($description)) {
                    $str .= "\t\t\t<description><![CDATA[" . $description. "]]></description>" . PHP_EOL;
                }

                $str .= "\t\t</item>" . PHP_EOL;

                fwrite($handle, $str);
                
            }

            fwrite(
                $handle,
                "\t</channel>" . PHP_EOL .
                "</rss>"
            );

            fclose($handle);
            chmod($filePath, 0777);
        }
    }
}
