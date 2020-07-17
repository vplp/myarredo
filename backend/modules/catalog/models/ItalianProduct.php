<?php

namespace backend\modules\catalog\models;

use Yii;
use common\modules\catalog\models\ItalianProduct as CommonItalianProductModel;
use thread\app\model\interfaces\BaseBackendModel;

/**
 * Class ItalianProduct
 *
 * @package backend\modules\catalog\models
 */
class ItalianProduct extends CommonItalianProductModel implements BaseBackendModel
{
    /**
     * @param bool $insert
     * @param array $changedAttributes
     */
    public function afterSave($insert, $changedAttributes)
    {
        if (key_exists('status', $changedAttributes)) {
            $statusNew = Yii::$app->request->getBodyParam('ItalianProduct')['status'];
            $statusOld = $changedAttributes['status'];

            if ($statusNew == 'not_approved') {
                /**
                 * send user letter
                 */
                Yii::$app
                    ->mailer
                    ->compose(
                        '@backend/modules/catalog/mail/letter_italian_product_not_approved',
                        [
                            'model' => $this,
                            'text' => Yii::$app->param->getByName('MAIL_ITALIAN_PRODUCT_NOT_APPROVED_TEXT')
                        ]
                    )
                    ->setTo($this->user->email)
                    ->setSubject($this->lang->title)
                    ->send();
            } elseif ($statusNew == 'approved') {
                /**
                 * send user letter
                 */
                Yii::$app
                    ->mailer
                    ->compose(
                        '@backend/modules/catalog/mail/letter_italian_product_approved',
                        [
                            'model' => $this,
                            'text' => Yii::$app->param->getByName('MAIL_ITALIAN_PRODUCT_APPROVED_TEXT')
                        ]
                    )
                    ->setTo($this->user->email)
                    ->setSubject($this->lang->title)
                    ->send();
            }
        }

        parent::afterSave($insert, $changedAttributes);
    }

    /**
     * @param $params
     * @return \yii\data\ActiveDataProvider
     */
    public function search($params)
    {
        return (new search\ItalianProduct())->search($params);
    }

    /**
     * @param $params
     * @return \yii\data\ActiveDataProvider
     */
    public function trash($params)
    {
        return (new search\ItalianProduct())->trash($params);
    }
}
