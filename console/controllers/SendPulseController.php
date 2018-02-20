<?php

namespace console\controllers;

use Yii;
use yii\console\Controller;
use yii\helpers\Console;
//
use frontend\modules\location\models\Country;
use frontend\modules\user\models\{
    User, Group, Profile
};
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
                ->andWhere([
                    'group_id' => Group::PARTNER,
                    Profile::tableName() . '.country_id' => $country['id']
                ])
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
     * SendPulse: remove emails
     */
    public function actionRemoveEmails()
    {
        $this->stdout("SendPulse: start remove emails. \n", Console::FG_GREEN);

        $modelCountry = Country::findBase()->all();

        foreach ($modelCountry as $country) {

            $bookId = $country['bookId'];
            $emails = [];

            $requestResult = Yii::$app->sendPulse->getEmailsFromBook($bookId);

            foreach ($requestResult as $item) {
                $modelUser = User::findBase()
                    ->andWhere([
                        'group_id' => Group::PARTNER,
                        'email' => $item->email,
                    ])
                    ->one();

                if ($modelUser == null) {
                    $emails[] = $item->email;
                }
            }

            if (!empty($emails)) {
                Yii::$app->sendPulse->removeEmails($bookId, $emails);
            }
        }

        $this->stdout("SendPulse: end remove emails. \n", Console::FG_GREEN);
    }


    /**
     * SendPulse: send test campaign
     */
    public function actionSendCampaign()
    {
        $this->stdout("SendPulse: start send test campaign. \n", Console::FG_GREEN);

        $modelOrder = Order::findBase()
            ->andWhere(['create_campaign' => '0'])
            ->one();

        if ($modelOrder !== null) {
            $bookId = $modelOrder->city->country->bookId;
            $senderName = 'myarredo';
            $senderEmail = 'info@myarredo.ru';
            $subject = 'Новая заявка №' . $modelOrder['id'];
            $body = $this->renderPartial('letter_new_order_for_partner', ['order' => $modelOrder]);
            $name = 'Новая заявка №' . $modelOrder['id'];

            $response = Yii::$app->sendPulse->createCampaign($senderName, $senderEmail, $subject, $body, $bookId, $name);

            $response = (array)$response;

            if (isset($response['is_error']) && $response['is_error'] == 0) {
                // set create_campaign and save
                $modelOrder->setScenario('create_campaign');
                $modelOrder->create_campaign = '1';
                $modelOrder->save();

                $this->stdout("Create campaign: " . $subject . " \n", Console::FG_GREEN);
            }

            /* !!! */
            echo '<pre style="color:red;">';
            print_r($response);
            echo '</pre>'; /* !!! */
        }

        $this->stdout("SendPulse: end send test campaign. \n", Console::FG_GREEN);
    }
}