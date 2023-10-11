<?php

namespace backend\modules\forms\controllers;

use yii\helpers\ArrayHelper;
//
use thread\actions\Update;
use thread\app\base\controllers\BackendController;
//
use backend\modules\forms\models\{
    FormsFeedback, search\FormsFeedback as SearchFormsFeedback
};

/**
 * Class FormsFeedbackController
 *
 * @package backend\modules\forms\controllers
 */
class FormsFeedbackController extends BackendController
{
    public $title = 'Feedback';
    public $name = 'Feedback';
    public $model = FormsFeedback::class;
    public $filterModel = SearchFormsFeedback::class;

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
