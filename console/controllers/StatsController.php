<?php

namespace console\controllers;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Console;
use yii\console\Controller;
//
use frontend\modules\catalog\models\{
    Product, ProductStats, ProductStatsDays
};

/**
 * Class StatsController
 *
 * @package console\controllers
 */
class StatsController extends Controller
{
    public function actionIndex($time = 0)
    {
        $this->stdout("Start. \n", Console::FG_GREEN);

        $timestamp = ($time)
            ? strtotime($time)
            : strtotime(date('d-m-Y', time() - 60 * 60 * 24));

        $params = [];

        $params['start_date'] = date('d-m-Y', $timestamp);
        $params['end_date'] = date('d-m-Y', $timestamp);

        $data = ProductStats::find()
            ->select([
                ProductStats::tableName() . '.product_id',
                ProductStats::tableName() . '.city_id',
                'count(' . ProductStats::tableName() . '.product_id) as views',
            ])
            ->innerJoinWith(["product"])
            ->andWhere(['>=', ProductStats::tableName() . '.created_at', strtotime($params['start_date'] . ' 0:00')])
            ->andWhere(['<=', ProductStats::tableName() . '.created_at', strtotime($params['end_date'] . ' 23:59')])
            ->groupBy(ProductStats::tableName() . '.product_id, ' . ProductStats::tableName() . '.city_id')
            ->orderBy('views DESC')
            ->asArray()
            ->all();

        foreach ($data as $item) {
            $model = new ProductStatsDays();

            $model->setScenario('frontend');

            $model->product_id = $item['product']['id'];
            $model->factory_id = $item['product']['factory_id'];
            $model->country_id = 0;
            $model->city_id = $item['city_id'];
            $model->views = $item['views'];
            $model->requests = 0;
            $model->date = mktime(0, 0, 0, date("m", $timestamp), date("d", $timestamp), date("Y", $timestamp));

            $model->save();

            $this->stdout($item['product_id'] . ' ' . $item['city_id'] . ' ' . $item['views'] . "\n", Console::FG_GREEN);
        }

        $this->stdout("Finish. \n", Console::FG_GREEN);
    }
}