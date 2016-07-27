<?php
namespace backend\modules\forms\controllers;

use Yii;
use yii\helpers\ArrayHelper;
use thread\app\base\controllers\BackendController;
use thread\actions\{
    Create, ListModel, Update
};
use backend\modules\forms\models\search\FeedbackForm;

/**
 * @author Alla Kuzmenko
 */
class FeedbackformController extends BackendController
{
    public $title = 'Feedback form';
    public $model = FeedbackForm::class;

    public function actions(){
        return ArrayHelper::merge(parent::actions(), [
            'list' => [
                'class' => ListModel::class,
                'modelClass' => $this->model,
                'layout' => '@app/layouts/base',
            ],
            'create' => [
                'class' => Create::class,
            ],
            'update' => [
                'class' => Update::class,
            ],
        ]);
    }
}
