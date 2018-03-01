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
     * SendPulse: send partner campaign campaign
     */
    public function actionSendCampaign()
    {
        $this->stdout("SendPulse: start send test campaign. \n", Console::FG_GREEN);

        // get order

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

            // send partner campaign

            $response = Yii::$app->sendPulse->createCampaign($senderName, $senderEmail, $subject, $body, $bookId, $name);

            var_dump($response);

            // send factory campaign

            foreach ($modelOrder->items as $item) {
                if ($item->product['factory_id']) {
                    $modelUser = User::findBase()
                        ->andWhere([
                            'group_id' => Group::FACTORY,
                            Profile::tableName() . '.factory_id' => $item->product['factory_id']
                        ])
                        ->one();

                    if ($modelUser !== null) {
                        Yii::$app
                            ->mailer
                            ->compose(
                                'letter_new_request_for_factory',
                                [
                                    'order' => $modelOrder,
                                    'item' => $item,
                                    'modelUser' => $modelUser
                                ]
                            )
                            ->setTo('zndron@gmail.com') // $modelUser['email']
                            ->setSubject('Новый запрос на товар')
                            ->send();
                    }

                }
            }

            $modelOrder->setScenario('create_campaign');
            $modelOrder->create_campaign = '1';
            $modelOrder->save();

            $this->stdout("Create campaign: " . $subject . " \n", Console::FG_GREEN);
        }

        $this->stdout("SendPulse: end send test campaign. \n", Console::FG_GREEN);
    }
}