<?php

namespace frontend\modules\shop\controllers;

use Yii;
use yii\filters\{
    VerbFilter, AccessControl
};
use yii\data\ActiveDataProvider;
use frontend\components\BaseController;
use frontend\modules\shop\models\OrderComment;

/**
 * Class OrderCommentController
 *
 * @package frontend\modules\shop\controllers
 */
class OrderCommentController extends BaseController
{
    public $title = '';

    public $defaultAction = 'reminder';

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'reminder' => ['get']
                ],
            ],
            'AccessControl' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                    [
                        'allow' => false,
                    ],
                ],
            ],
        ];
    }

    /**
     * @return string
     */
    public function actionReminder()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => OrderComment::getReminder(),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        $this->title = Yii::t('shop', 'Напоминание');

        return $this->render('reminder', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @param $id
     * @return \yii\web\Response
     */
    public function actionProcessed($id)
    {
        $model = OrderComment::findById($id);

        /** @var $model OrderComment */

        if ($model == null) {
            throw new NotFoundHttpException(Yii::t('yii', 'Page not found.'));
        }

        $model->scenario = 'processed';
        $model->processed = '1';
        $model->save();

        return $this->redirect(Yii::$app->request->referrer);
    }
}
