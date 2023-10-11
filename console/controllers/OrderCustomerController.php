<?php

namespace console\controllers;

use Yii;
use yii\console\Controller;
use yii\helpers\ArrayHelper;
use yii\helpers\Console;
use frontend\modules\catalog\models\Factory;
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
     * @throws \yii\db\Exception
     */
    public function actionResetOrderMark($mark = 'mark')
    {
        $this->stdout("Reset " . $mark . ": start. \n", Console::FG_GREEN);

        Yii::$app->db->createCommand()
            ->update(Order::tableName(), [$mark => '0'], $mark . "='1'")
            ->execute();

        $this->stdout("Reset " . $mark . ": finish. \n", Console::FG_GREEN);
    }

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

        $models = Order::find()
            ->innerJoinWith(['customer'])
            ->andFilterWhere([
                $mark => '0',
            ])
            ->limit(1000)
            ->orderBy(Order::tableName() . '.id ASC')
            ->all();

        foreach ($models as $model) {
            /** @var $model Order */

            $this->stdout("order ID = " . $model->id . " \n", Console::FG_GREEN);

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

        if ($RuEmails) {
            Yii::$app->sendPulse->addEmails($RuCustomerBookId, $RuEmails);
        }

        if ($UaEmails) {
            Yii::$app->sendPulse->addEmails($UaCustomerBookId, $UaEmails);
        }

        if ($ByEmails) {
            Yii::$app->sendPulse->addEmails($ByCustomerBookId, $ByEmails);
        }

        $this->stdout("SendPulse: end import customer. \n", Console::FG_GREEN);
    }

    /**
     * @inheritDoc
     */
    public function actionImportItalianFactoriesToSendPulse()
    {
        $this->stdout("SendPulse: start import italian factories. \n", Console::FG_GREEN);

        $emails = [];

        $ItFactoriesBookId = 88958746;

        $modelUsers = User::findBase()
            ->andWhere([User::tableName() . '.group_id' => Group::FACTORY])
            ->all();

        foreach ($modelUsers as $model) {
            /** @var $model User */
            $emails[] = [
                'email' => $model->email,
                'variables' => [
                    'name' => $model->profile->factory_id
                        ? $model->profile->factory->title
                        : $model->profile->getFullName(),
                ],
            ];
        }

        $modelFactories = Factory::find()
            ->andFilterWhere(['<>', Factory::tableName() . '.email', ''])
            ->all();

        foreach ($modelFactories as $model) {
            /** @var $model Factory */
            $emails[] = [
                'email' => $model->email,
                'variables' => [
                    'name' => $model->title,
                ],
            ];
        }

        Yii::$app->sendPulse->addEmails($ItFactoriesBookId, $emails);

        $this->stdout("SendPulse: end import italian factories. \n", Console::FG_GREEN);
    }
}
