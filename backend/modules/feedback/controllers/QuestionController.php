<?php

namespace backend\modules\feedback\controllers;

use thread\actions\{
    Create, Update
};

use yii\helpers\ArrayHelper;
//
use thread\app\base\controllers\BackendController;
//
use backend\modules\feedback\models\{
    Question, search\Question as filterArticleModel
};

/**
 * Class QuestionController
 *
 * @package backend\modules\feedback\controllers
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c), Thread
 */
class QuestionController extends BackendController
{
    public $model = Question::class;
    public $filterModel = filterArticleModel::class;
    public $title = 'Question';
    public $name = 'feedback';

    /**
     * @return array
     */
    public function actions()
    {
        return ArrayHelper::merge(
            parent::actions(),
            [
                'create' => [
                    'class' => Create::class
                ],
                'update' => [
                    'class' => Update::class
                ],
                'list' => [
                    'layout' => 'list-article',
                ],
            ]
        );
    }
}
