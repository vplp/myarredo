<?php

namespace console\controllers;

use Yii;
use yii\helpers\Console;
use yii\console\Controller;
use frontend\modules\catalog\models\{
    ItalianProductStats, ItalianProductStatsDays
};
use frontend\modules\shop\models\{
    Order, OrderItem
};

/**
 * Class ItalianProductStatsController
 *
 * @package console\controllers
 */
class ItalianProductStatsController extends Controller
{
    /**
     * @throws \yii\db\Exception
     */
    public function actionResetViews()
    {
        $this->stdout("ResetViews: start. \n", Console::FG_GREEN);

        Yii::$app->db->createCommand()
            ->update(ItalianProductStats::tableName(), ['mark' => '0'])
            ->execute();

        Yii::$app->db->createCommand()
            ->update(ItalianProductStatsDays::tableName(), ['views' => '0'])
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
            ->update(Order::tableName(), ['mark' => '0'], "product_type = 'sale-italy'")
            ->execute();

        Yii::$app->db->createCommand()
            ->update(ItalianProductStatsDays::tableName(), ['requests' => '0'])
            ->execute();

        $this->stdout("ResetRequests: finish. \n", Console::FG_GREEN);
    }

    /**
     *
     */
    public function actionViews()
    {
        $this->stdout("Start. \n", Console::FG_GREEN);

        $data = ItalianProductStats::find()
            ->innerJoinWith(["italianProduct"])
            ->where([
                ItalianProductStats::tableName() . '.mark' => '0',
            ])
            ->limit(5000)
            ->all();

        foreach ($data as $item) {
            $timestamp = strtotime(date('d-m-Y', $item['created_at']));
            $date = mktime(0, 0, 0, date("m", $timestamp), date("d", $timestamp), date("Y", $timestamp));

            $model = ItalianProductStatsDays::find()
                ->andWhere([
                    'product_id' => $item['product_id'],
                    'city_id' => $item['city_id'],
                    'factory_id' => $item['italianProduct']['factory_id'],
                    'date' => $date,
                ])
                ->one();

            if ($model == null) {
                $model = new ItalianProductStatsDays();
            }

            $model->setScenario('frontend');

            $model->product_id = $item['italianProduct']['id'];
            $model->factory_id = $item['italianProduct']['factory_id'];
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

        $data = Order::find()
            ->innerJoinWith(['items'])
            ->where([
                Order::tableName() . '.mark' => '0',
                Order::tableName() . '.product_type' => 'sale-italy',
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

                    $model = ItalianProductStatsDays::find()
                        ->andWhere([
                            'product_id' => $item['product_id'],
                            'city_id' => $order['city_id'],
                            'factory_id' => $item['product']['factory_id'],
                            'date' => $date,
                        ])
                        ->one();

                    if ($model == null) {
                        $model = new ItalianProductStatsDays();
                    }

                    $model->setScenario('frontend');

                    $model->product_id = $item['product']['id'];
                    $model->factory_id = $item['product']['factory_id'];
                    $model->country_id = 0;
                    $model->city_id = $order['city_id'];
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
}
