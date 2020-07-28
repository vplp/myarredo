<?php

namespace console\controllers;

use Yii;
use yii\helpers\Console;
use yii\console\Controller;
use frontend\modules\catalog\models\{
    SaleStats, SaleStatsDays, SalePhoneRequest
};
use frontend\modules\shop\models\{
    Order, OrderItem
};

/**
 * Class SaleStatsController
 *
 * @package console\controllers
 */
class SaleStatsController extends Controller
{
    /**
     * @throws \yii\db\Exception
     */
    public function actionResetViews()
    {
        $this->stdout("ResetViews: start. \n", Console::FG_GREEN);

        Yii::$app->db->createCommand()
            ->update(SaleStats::tableName(), ['mark' => '0'])
            ->execute();

        Yii::$app->db->createCommand()
            ->update(SaleStatsDays::tableName(), ['views' => '0'])
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
            ->update(SalePhoneRequest::tableName(), ['mark' => '0'])
            ->execute();

        Yii::$app->db->createCommand()
            ->update(SaleStatsDays::tableName(), ['requests' => '0'])
            ->execute();

        $this->stdout("ResetRequests: finish. \n", Console::FG_GREEN);
    }

    /**
     *
     */
    public function actionViews()
    {
        $this->stdout("Start. \n", Console::FG_GREEN);

        $data = SaleStats::find()
            ->innerJoinWith(['sale'])
            ->where([
                SaleStats::tableName() . '.mark' => '0',
            ])
            ->limit(5000)
            ->all();

        foreach ($data as $item) {
            $timestamp = strtotime(date('d-m-Y', $item['created_at']));
            $date = mktime(0, 0, 0, date("m", $timestamp), date("d", $timestamp), date("Y", $timestamp));

            $model = SaleStatsDays::find()
                ->andWhere([
                    'product_id' => $item['product_id'],
                    'city_id' => $item['city_id'],
                    'factory_id' => $item['sale']['factory_id'] ?? 0,
                    'date' => $date,
                ])
                ->one();

            if ($model == null) {
                $model = new SaleStatsDays();
            }

            $model->setScenario('frontend');

            $model->product_id = $item['sale']['id'];
            $model->factory_id = $item['sale']['factory_id'] ?? 0;
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
     *
     */
    public function actionRequests()
    {
        $this->stdout("Start. \n", Console::FG_GREEN);

        $data = SalePhoneRequest::find()
            ->where([
                SalePhoneRequest::tableName() . '.mark' => '0',
            ])
            ->limit(500)
            ->orderBy(['created_at' => SORT_DESC])
            ->all();

        /** @var $item SalePhoneRequest */

        foreach ($data as $item) {
            $timestamp = strtotime(date('d-m-Y', $item['created_at']));
            $date = mktime(0, 0, 0, date("m", $timestamp), date("d", $timestamp), date("Y", $timestamp));

            $model = SaleStatsDays::find()
                ->andWhere([
                    'product_id' => $item['sale_item_id'],
                    'city_id' => $item['city_id'],
                    'factory_id' => $item['sale']['factory_id'] ?? 0,
                    'date' => $date,
                ])
                ->one();

            if ($model == null) {
                $model = new SaleStatsDays();
            }

            $model->setScenario('frontend');

            $model->product_id = $item['sale_item_id'];
            $model->factory_id = $item['sale']['factory_id'] ?? 0;
            $model->country_id = 0;
            $model->city_id = $item['city_id'];
            $model->date = $date;

            $model->requests = $model->requests + 1;
            $model->save();

            $item->setScenario('mark');
            $item->mark = '1';

            if ($item->save()) {
                $this->stdout($item->id . " save \n", Console::FG_GREEN);
            }
        }

        $this->stdout("Finish. \n", Console::FG_GREEN);
    }
}
