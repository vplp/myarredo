<?php

namespace frontend\modules\shop\controllers;

use frontend\components\BaseController;
use Yii;
use yii\filters\AccessControl;
use frontend\modules\shop\models\Cart;


/**
 * Class CartController
 *
 * @package frontend\modules\shop\controllers
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c) 2014, Thread
 */
class WidgetController extends BaseController
{

    public $title = "Cart";
    public $defaultAction = 'index';
    private $cart_short = null;

    /**
     *
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
     * Екшин для того чтобы можно было обновить мальнькую корзину без перезагрузки страницы
     * @return string
     */
    public function actionIndex()
    {
        if (Yii::$app->request->isAjax) {
            return $this->render('index', [
            ]);
        } else {
            return $this->render('index', [
            ]);
        }
    }


}
