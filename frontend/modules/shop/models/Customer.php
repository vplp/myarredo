<?php

namespace frontend\modules\shop\models;

use common\modules\shop\models\Customer as CommonCustomerModel;


/**
 * Class Customer
 * @package frontend\modules\shop\models
 * @author FilamentV <vortex.filament@gmail.com>
 * @author Alla Kuzmenko
 * @copyright (c) 2016, VipDesign
 */
class Customer extends CommonCustomerModel
{
    /**
     *
     * @return array
     */
    public function scenarios()
    {
        return [
            'addnewcustorem' => ['email', 'phone', 'full_name', 'user_id'],
        ];
    }

    /**
     *
     * @param string $email
     * @return boolean
     */
    public static function addNewCustomer($params)
    {
        $customer = new Customer();

        if ($customer::find()->andWhere(['email'=>$params['email']])->one() === null) {

            $model = new Customer();
            $model->scenario = 'addnewcustorem';
            //$model->user_id = $params['user_id'];
            $model->email = $params['email'];
            $model->phone = $params['phone'];
            $model->full_name = $params['full_name'];
            
            $transaction = $model::getDb()->beginTransaction();
            try {
                if ($model->save()) {
                    $transaction->commit();
                    return $model->id;
                } else {
                    $transaction->rollBack();
                }

            } catch (Exception $e) {
                Yii::getLogger()->log($e->getMessage(), Logger::LEVEL_ERROR);
                $transaction->rollBack();
            }
        } else {
            return $customer->id;
        }
    }
}