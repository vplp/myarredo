<?php

namespace console\controllers;

use Yii;
use yii\helpers\Console;
use yii\console\Controller;
//
use frontend\modules\catalog\models\{
    SaleStats, SaleStatsDays
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
                    'factory_id' => $item['sale']['factory_id'],
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
                $item->setScenario('setMark');
                $item->mark = '1';
                $item->save();
            }
        }

        $this->stdout("Finish. \n", Console::FG_GREEN);
    }
}
