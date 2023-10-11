<?php

namespace backend\modules\forms\controllers;

use yii\helpers\ArrayHelper;
//
use thread\actions\Update;
use thread\app\base\controllers\BackendController;
//
use backend\modules\forms\models\{
    FormsFeedbackAfterOrder, search\FormsFeedbackAfterOrder as SearchFormsFeedbackAfterOrder
};

/**
 * Class FormsFeedbackAfterOrderController
 *
 * @package backend\modules\forms\controllers
 */
class FormsFeedbackAfterOrderController extends BackendController
{
    public $title = 'FeedbackAfterOrder';
    public $name = 'FeedbackAfterOrder';
    public $model = FormsFeedbackAfterOrder::class;
    public $filterModel = SearchFormsFeedbackAfterOrder::class;

    public function actions()
    {
        return ArrayHelper::merge(
            parent::actions(),
            [
                'list' => [
                    'layout' => "list"
                ],
                'create' => false,
                'update' => [
                    'class' => Update::class,
                ]
            ]
        );
    }
}
