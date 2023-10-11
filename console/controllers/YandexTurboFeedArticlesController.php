<?php

namespace console\controllers;

use Yii;
use yii\helpers\Console;
use yii\console\Controller;
use frontend\modules\location\models\{City, Currency};
use frontend\modules\articles\models\Article;

/**
 * Class YandexTurboFeedArticlesController
 *
 * @package console\controllers
 */
class YandexTurboFeedArticlesController extends Controller
{
    public $filePath = '@root/web/turbo-feed/articles/';

    public $countOffersInFeed = 20000;

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

        $query = Article::findBase()->asArray();

        $offers = [];
        foreach ($query->batch(100) as $models) {
            foreach ($models as $item) {
                $offers[] = $item;
            }
        }

        /** @var $city City */
        foreach ($cities as $city) {
            if ($city['id'] == 4) {
                $this->createFeed($city, $offers);
            }
        }

        $this->stdout("YandexTurboFeed: end create. \n", Console::FG_GREEN);
    }

    /**
     * @param $city
     * @param $offers
     */
    protected function createFeed($city, $offers)
    {
        $count = count($offers);
        $countFiles = ceil($count / $this->countOffersInFeed);

        for ($i = 0; $i < $countFiles; $i++) {
            $filePath = Yii::getAlias($this->filePath . '/turbo_feed_articles_' . $i . '.xml');

            $handle = fopen($filePath, "w");

            fwrite(
                $handle,
                "<?xml version=\"1.0\" encoding=\"UTF-8\"?>" . PHP_EOL .
                "<rss xmlns:yandex=\"http://news.yandex.ru\" xmlns:media=\"http://search.yahoo.com/mrss/\" xmlns:turbo=\"http://turbo.yandex.ru\" version=\"2.0\">" . PHP_EOL .
                "<channel>" . PHP_EOL .
                "<title>MyArredoFamily</title>" . PHP_EOL .
                "<link>" . City::getSubDomainUrl($city) . "</link>" . PHP_EOL .
                "<description>MyArredoFamily</description>" . PHP_EOL .
                "<language>ru</language>" . PHP_EOL
            );

            for ($j = $i * $this->countOffersInFeed; $j <= ($i + 1) * $this->countOffersInFeed; $j++) {
                if (isset($offers[$j])) {
                    $offer = $offers[$j];
                    /** @var $offer Article */
                    $url = City::getSubDomainUrl($city) . '/articles/' . $offer['alias'] . '/';

                    $content = "<header>" . "<h1>" . $offer['lang']['title'] . "</h1>" . "</header>";

                    if (Article::isImage($offers[$j]['image_link'])) {
                        $content .= "<figure><img src=\"" . City::getSubDomainUrl($city) . Article::getImageThumb($offer['image_link']) . "\"/></figure>";
                    }

                    $content .= "<article>" . $offer['lang']['content'] . "</article>";

                    $str = "\t<item turbo=\"true\">" . PHP_EOL .
                        "\t\t<link>" . $url . "</link>" . PHP_EOL .
                        //"\t\t<pubDate>" . ($offer['published_time'] ? date(DATE_RFC822, $offer['published_time']) : '') . "</pubDate>" . PHP_EOL .
                        "\t\t<turbo:content><![CDATA[" . $content . "]]></turbo:content>" . PHP_EOL .
                        "\t</item>" . PHP_EOL;

                    fwrite($handle, $str);
                }
            }

            fwrite(
                $handle,
                "</channel>" . PHP_EOL .
                "</rss>"
            );

            fclose($handle);
            chmod($filePath, 0777);
        }
    }
}
