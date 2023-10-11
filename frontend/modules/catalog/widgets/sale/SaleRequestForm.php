<?php

namespace frontend\modules\catalog\widgets\sale;

use Yii;
use yii\base\Widget;
use yii\db\mssql\PDO;
//
use frontend\modules\catalog\models\{
    Sale, SaleRequest
};
use frontend\modules\user\components\UserIpComponent;

/**
 * Class SaleRequestForm
 *
 * @property integer $sale_item_id
 *
 * @package frontend\modules\catalog\widgets\sale
 */
class SaleRequestForm extends Widget
{
    /**
     * @var string
     */
    public $view = 'sale_request_form_popup';

    /**
     * @var int
     */
    public $sale_item_id = 0;

    /**
     * @return string
     * @throws \yii\base\InvalidConfigException
     */
    public function run()
    {
        $model = new SaleRequest();

        $model->setScenario('requestForm');

        $modelSale = Sale::findById($this->sale_item_id);
        /** @var $modelSale Sale */

        if ($modelSale != null && $model->load(Yii::$app->getRequest()->post())) {
            $model->user_id = Yii::$app->getUser()->id ?? 0;
            $model->sale_item_id = $this->sale_item_id;
            $model->country_id = Yii::$app->city->getCountryId();
            $model->city_id = Yii::$app->city->getCityId();
            $model->ip = (new UserIpComponent())->ip;//Yii::$app->request->userIP;

            /** @var PDO $transaction */
            $transaction = $model::getDb()->beginTransaction();
            try {
                $save = $model->save();
                if ($save) {
                    $transaction->commit();

                    $to[] = 'info@myarredo.ru';

                    if ($modelSale->user->profile->show_contacts_on_sale) {
                        $to[] = $modelSale->user['email'];
                    }

                    // send letter
                    Yii::$app
                        ->mailer
                        ->compose(
                            '@app/modules/catalog/mail/sale_request_form_letter.php',
                            [
                                'model' => $model,
                                'modelSale' => $modelSale,
                            ]
                        )
                        ->setTo($to)
                        ->setSubject('Поступил новый вопрос на товар')
                        ->send();

                    // message
                    Yii::$app->getSession()->setFlash(
                        'success',
                        Yii::t('app', 'Отправлено')."<script>window.reachGoal='order';</script>"
                    );

                    $model = new SaleRequest();

                } else {
                    $transaction->rollBack();
                }
            } catch (Exception $e) {
                $transaction->rollBack();
            }
        }

        return $this->render($this->view, [
            'model' => $model
        ]);
    }
}
