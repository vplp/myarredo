<?php
namespace backend\modules\shop\controllers;

use thread\app\base\controllers\BackendController;
//
use backend\modules\shop\models\{
    PaymentMethods, PaymentMethodsLang, search\PaymentMethods as filterPaymentMethodsModel
};

/**
 * Class PaymentMethodsController
 *
 * @package backend\modules\location\controllers
 */
class PaymentMethodsController extends BackendController
{
    public $model = PaymentMethods::class;
    public $modelLang = PaymentMethodsLang::class;
    public $filterModel = filterPaymentMethodsModel::class;
    public $title = 'Payment Methods';
    public $name = 'Payment Methods';
}