<?php
namespace backend\modules\shop\controllers;

use thread\app\base\controllers\BackendController;
//
use backend\modules\shop\models\{
    OrderItem, search\OrderItem as filterOrderItemModel
};

/**
 * Class OrderItemController
 *
 * @package backend\modules\location\controllers
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class OrderItemController extends BackendController
{
    public $model = OrderItem::class;
    public $filterModel = filterOrderItemModel::class;
    public $title = 'OrderItem';
    public $name = 'OrderItem';
}