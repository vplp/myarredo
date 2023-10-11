<?php

namespace console\controllers;

use Yii;
use yii\helpers\Console;
use yii\console\Controller;
use frontend\modules\location\models\City;
use frontend\modules\catalog\models\{
    ProductStats, ProductStatsDays, FactoryStatsDays
};
use frontend\modules\shop\models\{
    Order, OrderItem
};

/**
 * Class StatsController
 *
 * @package console\controllers
 */
class StatsController extends Controller
{
    /**
     * @throws \yii\db\Exception
     */
    public function actionResetViews()
    {
        $this->stdout("ResetViews: start. \n", Console::FG_GREEN);

        Yii::$app->db->createCommand()
            ->update(ProductStats::tableName(), ['mark' => '0'])
            ->execute();

        Yii::$app->db->createCommand()
            ->update(ProductStatsDays::tableName(), ['views' => '0'])
            ->execute();

        $this->stdout("ResetViews: finish. \n", Console::FG_GREEN);
    }

    /**
     * @throws \yii\db\Exception
     */
    public function actionResetRequests()
    {
        $this->stdout("ResetRequests: start. \n", Console::FG_GREEN);

        Yii::$app->db->createCommand()
            ->update(Order::tableName(), ['mark' => '0'], "product_type = 'product'")
            ->execute();

        Yii::$app->db->createCommand()
            ->update(ProductStatsDays::tableName(), ['requests' => '0'])
            ->execute();

        $this->stdout("ResetRequests: finish. \n", Console::FG_GREEN);
    }

    /**
     * @inheritDoc
     */
    public function actionViews()
    {
        $this->stdout("Start. \n", Console::FG_GREEN);

        $data = ProductStats::find()
            ->innerJoinWith(["product"])
            ->where([
                ProductStats::tableName() . '.mark' => '0',
            ])
            ->limit(5000)
            ->all();

        foreach ($data as $item) {
            $timestamp = strtotime(date('d-m-Y', $item['created_at']));
            $date = mktime(0, 0, 0, date("m", $timestamp), date("d", $timestamp), date("Y", $timestamp));

            $model = ProductStatsDays::find()
                ->andWhere([
                    'product_id' => $item['product_id'],
                    'city_id' => $item['city_id'],
                    'factory_id' => $item['product']['factory_id'],
                    'date' => $date,
                ])
                ->one();

            if ($model == null) {
                $model = new ProductStatsDays();
            }

            $model->setScenario('frontend');

            $model->product_id = $item['product']['id'];
            $model->factory_id = $item['product']['factory_id'];
            $model->country_id = 0;
            $model->city_id = $item['city_id'];
            $model->date = $date;

            $model->views = $model->views + 1;

            if ($model->save()) {
                $item->setScenario('mark');
                $item->mark = '1';
                $item->save();
            }
        }

        $this->stdout("Finish. \n", Console::FG_GREEN);
    }

    /**
     * @inheritDoc
     */
    public function actionRequests()
    {
        $this->stdout("Start. \n", Console::FG_GREEN);

        $data = Order::find()
            ->innerJoinWith(['items'])
            ->where([
                Order::tableName() . '.mark' => '0',
                Order::tableName() . '.product_type' => 'product',
            ])
            ->limit(500)
            ->orderBy(['created_at' => SORT_DESC])
            ->all();

        /** @var $order Order */
        /** @var $item OrderItem */

        foreach ($data as $order) {
            foreach ($order->items as $item) {
                if ($item['product']) {
                    $timestamp = strtotime(date('d-m-Y', $order['created_at']));
                    $date = mktime(0, 0, 0, date("m", $timestamp), date("d", $timestamp), date("Y", $timestamp));

                    $city_id = $order['city_id'];
                    if ($city_id == 0 && $order['country_id'] > 0) {
                        $model = City::findOne(['country_id' => $order['country_id']]);
                        if ($model) {
                           $city_id = $model->id;
                        }
                    }
                    $model = ProductStatsDays::find()
                        ->andWhere([
                            'product_id' => $item['product_id'],
                            'city_id' => $city_id,
                            'factory_id' => $item['product']['factory_id'],
                            'date' => $date,
                        ])
                        ->one();

                    if ($model == null) {
                        $model = new ProductStatsDays();
                    }

                    $model->setScenario('frontend');

                    $model->product_id = $item['product']['id'];
                    $model->factory_id = $item['product']['factory_id'];
                    $model->country_id = 0;
                    $model->city_id = $city_id;
                    $model->date = $date;

                    $model->requests = $model->requests + 1;
                    $model->save();
                }
            }

            $order->setScenario('mark');
            $order->mark = '1';

            if ($order->save()) {
                $this->stdout($order->id . " save \n", Console::FG_GREEN);
            }
        }

        $this->stdout("Finish. \n", Console::FG_GREEN);
    }

    /**
     * @inheritDoc
     */
    public function actionFactoryStatsDays()
    {
        $this->stdout("Start. \n", Console::FG_GREEN);

        $end_date = mktime(23, 59, 0, date("m"), date("d"), date("Y"));

        $data = ProductStatsDays::find()
            ->andWhere([
                ProductStatsDays::tableName() . '.mark' => '0',
            ])
            ->andWhere([
                '<=', ProductStatsDays::tableName() . '.date', $end_date
            ])
            ->orderBy(ProductStatsDays::tableName() . '.date ASC')
            ->limit(5000)
            ->all();

        foreach ($data as $item) {
            /** @var $item ProductStatsDays */

            $model = FactoryStatsDays::find()
                ->andWhere([
                    'city_id' => $item['city_id'],
                    'factory_id' => $item['factory_id'],
                    'date' => $item['date'],
                ])
                ->one();

            if ($model == null) {
                $model = new FactoryStatsDays();
            }

            $model->setScenario('frontend');

            $model->factory_id = $item['factory_id'];
            $model->country_id = $item['country_id'];
            $model->city_id = $item['city_id'];
            $model->date = $item['date'];
            $model->views = $model->views + $item['views'];
            $model->requests = $model->requests + $item['requests'];

            if ($model->save()) {
                $item->setScenario('mark');
                $item->mark = '1';
                $item->save();
            }
        }

        $this->stdout("Finish. \n", Console::FG_GREEN);
    }

    /**
     * @inheritDoc
     */
    public function actionDelFactoryStatsDays()
    {
        $data = FactoryStatsDays::find()
            ->andWhere([
                FactoryStatsDays::tableName() . '.city_id' => '0',
            ])
            ->andWhere([
                '>', FactoryStatsDays::tableName() . '.requests', 0
            ])
            ->all();
        file_put_contents('/var/www/www-root/data/www/myarredo.ru/delFactoryStatsDays.scv','factory_id,country_id,city_id,views,requests,date'.PHP_EOL);
        foreach ($data as $item) {
            file_put_contents('/var/www/www-root/data/www/myarredo.ru/delFactoryStatsDays.scv',$item['factory_id'].','.$item['country_id'].','.$item['city_id'].','.$item['views'].','.$item['requests'].','.$item['date'].PHP_EOL, FILE_APPEND);
        }
    }
    /**
     * @inheritDoc
     */
    public function actionAlignFactoryStatsDays()
    {
        $start = microtime(true);
        $this->stdout("Start. \n", Console::FG_GREEN);

        
        $end_date = mktime(23, 59, 0, date("m"), date("d"), date("Y"));
        $start_date = $end_date - 60*60;

        while ($start_date > 60*60*24*366*5){
            echo "Star_date=".$start_date." End_date=".$end_date." \n";
            $data = ProductStatsDays::find()
                ->where([
                    'between', ProductStatsDays::tableName() . '.date', $start_date, $end_date
                ])
                ->orderBy(ProductStatsDays::tableName() . '.date ASC')
                ->all();

            $arAlign = array();
            foreach ($data as $item) {
                if (!isset($arAlign[$item->factory_id])) {
                    $arAlign[$item->factory_id] = array();
                }
                if (!isset($arAlign[$item->factory_id][$item->city_id])) {
                    $arAlign[$item->factory_id][$item->city_id] = array();
                }
                if (!isset($arAlign[$item->factory_id][$item->city_id][$item->date])) {
                    $arAlign[$item->factory_id][$item->city_id][$item->date] = array('views'=>0,'requests'=>0,);
                }

                $arAlign[$item->factory_id][$item->city_id][$item->date]['views'] += $item->views;
                $arAlign[$item->factory_id][$item->city_id][$item->date]['requests'] += $item->requests;
            }
            $data = false;
            foreach ($arAlign as $factory_id => $cities) {
                foreach ($cities as $city_id => $dates) {
                    foreach ($dates as $date => $data) {
                        $model = FactoryStatsDays::find()
                        ->andWhere([
                            'city_id' => $city_id,
                            'factory_id' => $factory_id,
                            'date' => $date,
                        ])
                        ->one();

                        if ($model == null) {
                            $model = new FactoryStatsDays();
                        }

                        $model->setScenario('frontend');
                        $model->factory_id = $factory_id;
                        $model->country_id = 0;
                        $model->city_id = $city_id;
                        $model->date = $date;
                        $model->views = $data['views'];
                        $model->requests = $data['requests'];
                        $model->save();
                    }
                }
            }

            $end_date = $start_date + 1;
            $start_date = $end_date - 60*60;
        }
        echo 'Время выполнения скрипта: '.round(microtime(true) - $start, 4).' сек.';
        $this->stdout("Finish. \n", Console::FG_GREEN);
    }

}
