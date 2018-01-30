<?php

namespace console\controllers;

use Yii;
use yii\helpers\Html;
use yii\console\Controller;
use yii\helpers\Console;
//
use frontend\modules\location\models\Country;
use frontend\modules\user\models\{
    User, Group, Profile
};
use frontend\modules\catalog\models\Product;
use frontend\modules\shop\models\Order;

/**
 * Class SendPulseController
 *
 * @package console\controllers
 */
class SendPulseController extends Controller
{
    /**
     * SendPulse: import emails
     */
    public function actionImportEmails()
    {
        $this->stdout("SendPulse: start import emails. \n", Console::FG_GREEN);

        $modelCountry = Country::findBase()->all();

        foreach ($modelCountry as $country) {
            $modelUser = User::findBase()
                ->andWhere(['group_id' => Group::PARTNER, Profile::tableName() . '.country_id' => $country['id']])
                ->all();

            /**
             * Add new email to mailing lists
             */
            $bookId = $country['bookId'];
            $emails = [];

            foreach ($modelUser as $user) {
                $emails[] = [
                    'email' => $user['email'],
                    'variables' => [
                        'phone' => $user['profile']['phone'],
                        'name' => $user['profile']['fullName'],
                    ],
                ];
            }

            Yii::$app->sendPulse->addEmails($bookId, $emails);
        }

        $this->stdout("SendPulse: end import emails. \n", Console::FG_GREEN);
    }

    /**
     * SendPulse: send test campaign
     */
    public function actionSendTestCampaign()
    {
        $this->stdout("SendPulse: start send test campaign. \n", Console::FG_GREEN);

        $modelOrder = Order::findBase()
            ->andWhere(['create_campaign' => '0'])
            ->all();

        foreach ($modelOrder as $order) {
            $bookId = 1509649; //  $order->city->country->bookId
            $senderName = 'myarredo';
            $senderEmail = 'info@myarredo.ru';
            $subject = 'Новая заявка №' . $order['id'];
            $body = $this->renderPartial('letter_new_order_for_partner', ['order' => $order]);
            $name = 'Новая заявка №' . $order['id'];

            Yii::$app->sendPulse->createCampaign($senderName, $senderEmail, $subject, $body, $bookId, $name);

            // set create_campaign and save
            $order->setScenario('create_campaign');
            $order->create_campaign = '1';
            $order->save();
        }

        $this->stdout("SendPulse: end send test campaign. \n", Console::FG_GREEN);
    }
}