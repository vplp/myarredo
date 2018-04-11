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
    public function actionIndex()
    {
        $this->stdout("Start. \n", Console::FG_GREEN);

        // UPDATE `fv_catalog_item_stats` SET `mark`='0' WHERE `mark`='1'

        $data = ProductStats::find()
            ->innerJoinWith(["product"])
            ->where([
                ProductStats::tableName().'.mark' => '0',
            ])
            ->limit(2000)
            ->all();

        foreach ($data as $item) {

            $timestamp = strtotime(date('d-m-Y', $item['created_at']));
            $date = mktime(0, 0, 0, date("m", $timestamp), date("d", $timestamp), date("Y", $timestamp));

            $model = ProductStatsDays::find()
                ->andWhere([
                    'product_id' => $item['product_id'],
                    'city_id' => $item['city_id'],
                    'factory_id' => $item['product']['factory_id'],
                    'city_id' => $item['city_id'],
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

            if($model->save()) {
                $item->setScenario('setMark');
                $item->mark = '1';
                $item->save();
            }
        }

        $this->stdout("Finish. \n", Console::FG_GREEN);
    }
}