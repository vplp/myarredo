<?php

namespace frontend\modules\shop\modules\market\controllers;

use Yii;
use yii\db\Exception;
use yii\filters\AccessControl;
use frontend\components\BaseController;
use frontend\modules\shop\modules\market\models\MarketOrder;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;

/**
 * Class MarketOrderAdminController
 *
 * @package frontend\modules\shop\modules\market\controllers
 */
class MarketOrderAdminController extends BaseController
{
    public $title = '';
    public $defaultAction = 'list';

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
                        'roles' => ['admin', 'settlementCenter']
                    ],
                    [
                        'allow' => false,
                    ],
                ],
            ]
        ];
    }

    /**
     * @return string
     * @throws \Throwable
     */
    public function actionList()
    {
        $model = new MarketOrder();

        $params = Yii::$app->request->get() ?? [];

        $models = $model->search($params);

        $this->title = Yii::t('market', 'Market order');

        return $this->render('list', [
            'models' => $models,
            'model' => $model,
            'params' => $params,
        ]);
    }

    /**
     * @return string
     * @throws \Throwable
     */
    public function actionCreate()
    {
        $model = new MarketOrder();

        $model->scenario = 'frontend';

        if ($model->load(Yii::$app->getRequest()->post())) {
            $transaction = $model::getDb()->beginTransaction();
            try {
                $save = $model->save();
                if ($save) {
                    $transaction->commit();

                    foreach ($model->partners as $partner) {
                        // send user letter
                        Yii::$app
                            ->mailer
                            ->compose(
                                '/../mail/new_market_order_letter',
                                [
                                    'model' => $model,
                                    'partner' => $partner,
                                ]
                            )
                            ->setTo($partner['email'])
                            ->setSubject(Yii::t('market', 'Market order') . ' № ' . $model['id'])
                            ->send();
                    }

                    return $this->redirect(Url::toRoute(['/shop/market/market-order-admin/list']) . '#' . $model->id);
                } else {
                    $transaction->rollBack();
                }
            } catch (Exception $e) {
                $transaction->rollBack();
            }
        }

        $this->title = Yii::t('market', 'Добавить заказ');

        return $this->render('_form', [
            'model' => $model,
        ]);
    }

    /**
     * @param $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionUpdate($id)
    {
        $model = MarketOrder::findById($id);

        /** @var $model MarketOrder */

        if ($model == null) {
            throw new NotFoundHttpException(Yii::t('yii', 'Page not found.'));
        }

        $model->scenario = 'frontend';

        if ($model->load(Yii::$app->getRequest()->post())) {
            $transaction = $model::getDb()->beginTransaction();
            try {
                $save = $model->save();

                if ($save) {
                    $transaction->commit();
                } else {
                    $transaction->rollBack();
                }
            } catch (Exception $e) {
                $transaction->rollBack();
            }
        }

        return $this->redirect(Url::toRoute(['/shop/market/market-order-admin/list']) . '#' . $id);
    }
}
