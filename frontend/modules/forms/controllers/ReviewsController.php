<?php

namespace frontend\modules\forms\controllers;

use Yii;
use yii\log\Logger;
use yii\base\Exception;
use yii\web\Response;
use yii\web\UploadedFile;
use yii\filters\VerbFilter;
use frontend\components\BaseController;
use frontend\modules\forms\models\FormsFeedbackAfterOrder;
use frontend\modules\shop\models\Order;
use yii\web\NotFoundHttpException;
use frontend\modules\user\models\{
    User, Group, Profile
};
/**
 * Class ReviewsController
 *
 * @package frontend\modules\forms\controllers
 */
class ReviewsController extends BaseController
{
    public $title = 'Reviews';

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'view' => ['get'],
                ],
            ],
        ];
    }

    /**
     * @return string|Response
     */
    public function actionView($id)
    {
        $salon = User::findById($id);
        $this->title = Yii::t('app', 'Отзывы о салоне') .' '. $salon->profile->getNameCompany();
        $reviews = FormsFeedbackAfterOrder::findBase()->andWhere(['question_2'=> $id, 'published'=>1])->all();
        return $this->render('view', [
            'reviews' => $reviews,
        ]);
    }
}
