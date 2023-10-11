<?php

namespace backend\modules\shop\controllers;


use Yii;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use thread\app\base\controllers\BackendController;
use thread\actions\{
    ListModel, Update
};
use backend\modules\shop\models\{
    Customer,
    Order,
    OrderItem,
    search\OrderItem as filterOrderItemModel,
    OrderAnswer,
    OrderItemPrice
};

/**
 * Class OrderController
 *
 * @package backend\modules\location\controllers
 */
class OrderController extends BackendController
{
    public $model = Order::class;
    public $filterModel = filterOrderItemModel::class;
    public $title = 'Order';
    public $name = 'Order';

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'AccessControl' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['error'],
                        'roles' => ['?', '@'],
                    ],
                    [
                        'allow' => true,
                        'roles' => ['admin', 'settlementCenter'],
                    ],
                    [
                        'allow' => false,
                    ],
                ],
            ],
        ];
    }

    /**
     * @return array|array[]
     */
    public function actions()
    {
        return ArrayHelper::merge(
            parent::actions(),
            [
                'update' => [
                    'class' => Update::class,
                    'modelClass' => $this->model,
                    'scenario' => 'backend',
                    'redirect' => function () {
                        return ($_POST['save_and_exit']) ? $this->actionListLinkStatus : [
                            'update',
                            'id' => $this->action->getModel()->id
                        ];
                    }
                ],
                'list' => [
                    'class' => ListModel::class,
                    'modelClass' => $this->model
                ],
            ]
        );
    }

    public function actionClearOrders()
    {
        Order::deleteAll();
        OrderItem::deleteAll();
        Customer::deleteAll();

        Yii::$app->db->createCommand('ALTER TABLE ' . Order::tableName() . ' AUTO_INCREMENT = 1')->execute();
        Yii::$app->db->createCommand('ALTER TABLE ' . OrderItem::tableName() . ' AUTO_INCREMENT = 1')->execute();
        Yii::$app->db->createCommand('ALTER TABLE ' . Customer::tableName() . ' AUTO_INCREMENT = 1')->execute();
    }

    public function actionImportOrders()
    {
        $limitCount = 500;

        $dataOrder = (new \yii\db\Query())
            ->from('c1myarredo.order')
            ->where(['mark' => '0'])
            ->limit($limitCount)
            ->orderBy('id desc')
            ->all();

        foreach ($dataOrder as $order) {
            $user_profile = (new \yii\db\Query())
                ->from('c1myarredo.fv_user_profile')
                ->where(['user_id' => $order['user_id']])
                ->one();

            if ($user_profile != null) {
                $modelOrder = Order::findOne(['id' => $order['id']]);

                if ($modelOrder == null) {
                    $modelOrder = new Order();
                    $modelOrder->id = $order['id'];
                }

                $modelOrder->setScenario('backend');

                $modelOrder->comment = $order['comments_client'];
                $modelOrder->city_id = $order['city'];
                $modelOrder->created_at = $order['created'];
                $modelOrder->updated_at = $order['updated'];
                $modelOrder->published = '1';
                $modelOrder->deleted = '0';

                // save Customer
                {
                    $modelCustomer = Customer::findOne([
                        'user_id' => $order['user_id']
                    ]);

                    if ($modelCustomer == null) {
                        $modelCustomer = new Customer();
                    }

                    $modelCustomer->setScenario('backend');

                    $modelCustomer->user_id = $order['user_id'];
                    $modelCustomer->email = $order['e_mail'];
                    $modelCustomer->phone = $order['telephone'] ? $order['telephone'] : '--';

                    $modelCustomer->full_name = $user_profile['first_name'] ? $user_profile['first_name'] : '--';
                    $modelCustomer->created_at = $order['created'];
                    $modelCustomer->updated_at = $order['updated'];
                    $modelCustomer->published = '1';
                    $modelCustomer->deleted = '0';

                    $transaction = $modelCustomer::getDb()->beginTransaction();
                    try {
                        if ($modelCustomer->save()) {
                            $transaction->commit();
                        } else {
                            /* !!! */
                            echo '<pre style="color:red;">';
                            print_r($order['user_id']);
                            echo '</pre>'; /* !!! */
                            /* !!! */
                            echo '<pre style="color:red;">';
                            print_r($modelCustomer->getErrors());
                            echo '</pre>'; /* !!! */
                            die;
                        }
                    } catch (\Exception $e) {
                        $transaction->rollBack();
                        throw new \Exception($e);
                    }

                    $modelOrder->customer_id = $modelCustomer->id;

                }

                $transaction = $modelOrder::getDb()->beginTransaction();
                try {
                    if ($modelOrder->save()) {
                        $transaction->commit();
                    } else {
                        /* !!! */
                        echo '<pre style="color:red;">';
                        print_r($order['id']);
                        echo '</pre>'; /* !!! */
                        /* !!! */
                        echo '<pre style="color:red;">';
                        print_r($modelOrder->getErrors());
                        echo '</pre>'; /* !!! */
                        die;
                    }
                } catch (\Exception $e) {
                    $transaction->rollBack();
                    throw new \Exception($e);
                }

                // save OrderItem
                {
                    $dataOrderItem = (new \yii\db\Query())
                        ->from('c1myarredo.order_tovar')
                        ->where(['order_id' => $order['id']])
                        ->all();

                    foreach ($dataOrderItem as $orderItem) {

                        $modelOrderItem = OrderItem::findOne([
                            'order_id' => $orderItem['order_id'],
                            'product_id' => $orderItem['tovar_id']
                        ]);

                        if ($modelOrderItem == null) {
                            $modelOrderItem = new OrderItem();
                            $modelOrderItem->setScenario('backend');

                            $modelOrderItem->order_id = $orderItem['order_id'];
                            $modelOrderItem->product_id = $orderItem['tovar_id'];

                            $transaction = $modelOrderItem::getDb()->beginTransaction();
                            try {
                                if ($modelOrderItem->save()) {
                                    $transaction->commit();
                                } else {
                                    /* !!! */
                                    echo '<pre style="color:red;">';
                                    print_r($orderItem['id']);
                                    echo '</pre>'; /* !!! */
                                    /* !!! */
                                    echo '<pre style="color:red;">';
                                    print_r($modelOrderItem->getErrors());
                                    echo '</pre>'; /* !!! */
                                    die;
                                }
                            } catch (\Exception $e) {
                                $transaction->rollBack();
                                throw new \Exception($e);
                            }
                        }
                    }
                }

                // save Order Answer
                {
                    $dataOrderAnswer = (new \yii\db\Query())
                        ->from('c1myarredo.order_answer')
                        ->where(['order_id' => $order['id']])
                        ->all();

                    foreach ($dataOrderAnswer as $orderAnswer) {

                        $user_profile = (new \yii\db\Query())
                            ->from('c1myarredo.fv_user_profile')
                            ->where(['user_id' => $orderAnswer['partner_id']])
                            ->one();

                        if ($user_profile != null) {

                            $modelOrderAnswer = OrderAnswer::findOne([
                                'order_id' => $orderAnswer['order_id'],
                                'user_id' => $orderAnswer['partner_id']
                            ]);

                            if ($modelOrderAnswer == null) {
                                $modelOrderAnswer = new OrderAnswer();
                            }

                            $modelOrderAnswer->setScenario('backend');

                            $modelOrderAnswer->order_id = $orderAnswer['order_id'];
                            $modelOrderAnswer->user_id = $orderAnswer['partner_id'];
                            $modelOrderAnswer->answer = $orderAnswer['answer'];
                            $modelOrderAnswer->answer_time = $orderAnswer['answer_date_time'];
                            $modelOrderAnswer->results = $orderAnswer['results'];
                            $modelCustomer->published = '1';
                            $modelCustomer->deleted = '0';

                            $transaction = $modelOrderAnswer::getDb()->beginTransaction();
                            try {
                                if ($modelOrderAnswer->save()) {
                                    $transaction->commit();
                                } else {
                                    /* !!! */
                                    echo '<pre style="color:red;">';
                                    print_r($orderAnswer['id']);
                                    echo '</pre>'; /* !!! */
                                    /* !!! */
                                    echo '<pre style="color:red;">';
                                    print_r($modelOrderAnswer->getErrors());
                                    echo '</pre>'; /* !!! */
                                    die;
                                }
                            } catch (\Exception $e) {
                                $transaction->rollBack();
                                throw new \Exception($e);
                            }
                        }
                    }
                }

                // save OrderItemPrice
                {
                    $dataOrderItemPrice = (new \yii\db\Query())
                        ->from('c1myarredo.order_tovar_price')
                        ->where(['order_id' => $order['id']])
                        ->all();

                    foreach ($dataOrderItemPrice as $orderItemPrice) {

                        $user_profile = (new \yii\db\Query())
                            ->from('c1myarredo.fv_user_profile')
                            ->where(['user_id' => $orderItemPrice['partner_id']])
                            ->one();

                        if ($user_profile != null) {


                            $modelOrderItemPrice = OrderItemPrice::findOne([
                                'order_id' => $orderItemPrice['order_id'],
                                'product_id' => $orderItemPrice['tovar_id'],
                                'user_id' => $orderItemPrice['partner_id']
                            ]);

                            if ($modelOrderItemPrice == null) {
                                $modelOrderItemPrice = new OrderItemPrice();
                                $modelOrderItemPrice->setScenario('backend');

                                $modelOrderItemPrice->order_id = $orderItemPrice['order_id'];
                                $modelOrderItemPrice->product_id = $orderItemPrice['tovar_id'];
                                $modelOrderItemPrice->user_id = $orderItemPrice['partner_id'];
                                $modelOrderItemPrice->price = $orderItemPrice['price'] ? $orderItemPrice['price'] : 1;
                                $modelCustomer->created_at = $orderItemPrice['created'];
                                $modelCustomer->updated_at = $orderItemPrice['updated'];

                                $transaction = $modelOrderItemPrice::getDb()->beginTransaction();
                                try {
                                    if ($modelOrderItemPrice->save()) {
                                        $transaction->commit();
                                    } else {
                                        /* !!! */
                                        echo '<pre style="color:red;">';
                                        print_r($orderItem['id']);
                                        echo '</pre>'; /* !!! */
                                        /* !!! */
                                        echo '<pre style="color:red;">';
                                        print_r($modelOrderItemPrice->getErrors());
                                        echo '</pre>'; /* !!! */
                                        die;
                                    }
                                } catch (\Exception $e) {
                                    $transaction->rollBack();
                                    throw new \Exception($e);
                                }
                            }
                        }
                    }
                }

                Yii::$app->db->createCommand()
                    ->update(
                        'c1myarredo.order',
                        ['mark' => '1'],
                        'id = ' . $modelOrder->id
                    )
                    ->execute();
            }
        }
    }
}
