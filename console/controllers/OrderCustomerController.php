<?php

namespace console\controllers;

use Yii;
use yii\console\Controller;
use yii\helpers\ArrayHelper;
use yii\helpers\Console;
//
use frontend\modules\location\models\{
    Country, City
};
use frontend\modules\user\models\{
    User, Group, Profile
};
use frontend\modules\shop\models\Order;

/**
 * Class OrderCustomerController
 *
 * @package console\controllers
 */
class OrderCustomerController extends Controller
{
    /**
     * @param string $mark
     */
    public function actionImportCustomerToSendPulse($mark = 'mark1')
    {
        $this->stdout("SendPulse: start import customer. \n", Console::FG_GREEN);

        $RuCustomerBookId = 88958743;
        $UaCustomerBookId = 88958744;
        $ByCustomerBookId = 88958745;

        $RuEmails = $UaEmails = $ByEmails = [];

        $RuCity = ArrayHelper::map(City::findAll(['country_id' => 2]), 'id', 'id');
        $UaCity = ArrayHelper::map(City::findAll(['country_id' => 1]), 'id', 'id');
        $ByCity = ArrayHelper::map(City::findAll(['country_id' => 3]), 'id', 'id');

        $models = Order::findBase()
            ->andFilterWhere([
                $mark => '0',
            ])
            ->limit(50)
            ->orderBy(Order::tableName() . '.id ASC')
            ->all();

        foreach ($models as $model) {
            /** @var $model Order */

            $email = [
                'email' => $model->customer->email,
                'variables' => [
                    'name' => $model->customer->full_name,
                ],
            ];

            if (in_array($model->city_id, $RuCity)) {
                $RuEmails[] = $email;
            } elseif (in_array($model->city_id, $UaCity)) {
                $UaEmails[] = $email;
            } elseif (in_array($model->city_id, $ByCity)) {
                $ByEmails[] = $email;
            }

            $model->setScenario($mark);
            $model->$mark = '1';
            $model->save();
        }

        Yii::$app->sendPulse->addEmails($RuCustomerBookId, $RuEmails);
        Yii::$app->sendPulse->addEmails($UaCustomerBookId, $UaEmails);
        Yii::$app->sendPulse->addEmails($ByCustomerBookId, $ByEmails);

        $this->stdout("SendPulse: end import customer. \n", Console::FG_GREEN);
    }

    public function actionImportItalianFactoriesToSendPulse()
    {
        $this->stdout("SendPulse: start import italian factories. \n", Console::FG_GREEN);

        $ItFactoriesBookId = 88958746;

        $this->stdout("SendPulse: end import italian factories. \n", Console::FG_GREEN);
    }
}
