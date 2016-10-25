<?php

namespace frontend\modules\shop\controllers;

use Yii;
use frontend\components\BaseController;

/**
 * Class WidgetController
 *
 * @package frontend\modules\shop\controllers
 * @author Alla Kuzmenko
 * @copyright (c) 2014, Thread
 */
class WidgetController extends BaseController
{

    public $title = "Cart";
    public $defaultAction = 'index';


    /**
     * Екшин для того чтобы можно было обновить мальнькую корзину без перезагрузки страницы
     * @return string
     */
    public function actionIndex()
    {
        if (Yii::$app->request->isAjax) {
            return $this->render('index', [
            ]);
        }
    }


}
