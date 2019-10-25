<?php

namespace frontend\modules\user\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\helpers\Url;
//
use frontend\modules\location\models\City;
use frontend\components\BaseController;

/**
 * Class UserController
 *
 * @package frontend\modules\user\controllers
 */
class LogoutController extends BaseController
{

    public $title = "Logout";
    public $defaultAction = 'index';
    public $enableCsrfValidation = false;

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
                        'actions' => ['index'],
                        'roles' => ['?'],
                    ],
                    [
                        'allow' => true,
                        'roles' => ['@'],
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
    public function actionIndex()
    {
        Yii::$app->getUser()->logout();

        $model = Yii::$app->city->getCity();

        $url = (!in_array($model['id'], array(1, 2, 4, 159)))
            ? 'https://' . $model['alias'] . '.myarredo.' . Yii::$app->city->domain
            : 'https://' . 'www.myarredo.' . Yii::$app->city->domain;

        return $this->redirect($url);
    }
}
