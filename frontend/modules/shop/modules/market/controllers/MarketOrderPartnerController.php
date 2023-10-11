<?php

namespace frontend\modules\shop\modules\market\controllers;

use frontend\modules\shop\modules\market\models\MarketOrderAnswer;
use Yii;
use yii\db\Exception;
use yii\filters\AccessControl;
use frontend\components\BaseController;
use frontend\modules\shop\modules\market\models\MarketOrder;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;

/**
 * Class MarketOrderPartnerController
 *
 * @package frontend\modules\shop\modules\market\controllers
 */
class MarketOrderPartnerController extends BaseController
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
                        'roles' => ['partner']
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

        $modelAnswer = MarketOrderAnswer::findByOrderIdUserId($model->id, Yii::$app->user->id);

        if (empty($modelAnswer)) {
            $modelAnswer = new MarketOrderAnswer();
        }

        $modelAnswer->setScenario('frontend');
        $modelAnswer->order_id = $model->id;
        $modelAnswer->user_id = Yii::$app->user->id;

        if ($modelAnswer->load(Yii::$app->getRequest()->post())) {
            $transaction = $modelAnswer::getDb()->beginTransaction();
            try {
                $save = $modelAnswer->save();

                if ($save) {
                    $transaction->commit();
                } else {
                    $transaction->rollBack();
                }
            } catch (Exception $e) {
                $transaction->rollBack();
            }
        }

        return $this->redirect(Url::toRoute(['/shop/market/market-order-partner/list']) . '#' . $id);
    }
}
