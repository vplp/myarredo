<?php
namespace backend\modules\shop\controllers;

use thread\app\base\controllers\BackendController;
//
use backend\modules\shop\models\{
    DeliveryMethods, DeliveryMethodsLang, search\DeliveryMethods as filterDeliveryMethodsModel
};

/**
 * Class DeliveryMethodsController
 *
 * @package backend\modules\location\controllers
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class DeliveryMethodsController extends BackendController
{
    public $model = DeliveryMethods::class;
    public $modelLang = DeliveryMethodsLang::class;
    public $filterModel = filterDeliveryMethodsModel::class;
    public $title = 'Delivery Methods';
    public $name = 'Delivery Methods';
}