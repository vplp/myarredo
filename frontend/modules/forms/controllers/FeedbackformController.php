<?php
namespace frontend\modules\forms\controllers;

use Yii;
use yii\helpers\ArrayHelper;
use frontend\modules\forms\models\FeedbackForm;
use yii\web\Response;

/**
 * Class FeedbackformController
 *
 * @package frontend\modules\forms\controllers
 *  @author Alla Kuzmenko
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c) 2014, Thread
 */
class FeedbackformController extends \frontend\components\BaseController

{
    public $model = FeedbackForm::class;

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }


    public function actionAdd()
    {


        $model = new $this->model;
        $model->setScenario('addfeedback');

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            $response = ['success' => 0, 'fields' => [], 'location'=>\yii\helpers\Url::toRoute('/home/home/index')];
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($model->validate()) {
                $status = $model->addFeedback();
                if ($status === true) {
                    $response['success'] = 1;
                } else {
                    $response['success'] = 0;
                }
                return $response;
            } else {
                foreach ($model->getErrors() as $fiels => $val) {
                    $response['fields'][]['field'] = $fiels;
                    $response['fields'][count($response['fields']) - 1]['val'] = $val[0];
                }
                return $response;
            }
        } else {
            return $this->redirect(\yii\helpers\Url::toRoute('/home/home/index'));
        }
    }
}
